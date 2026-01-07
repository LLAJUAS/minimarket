<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Venta;
use App\Models\VentaProducto;
use App\Models\IngresoProducto;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Muestra el panel de administración.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index(Request $request): \Illuminate\Http\RedirectResponse|View
    {
        // 1. Obtener al usuario autenticado
        $user = Auth::user();

        // 2. Verificar permiso para el dashboard
        if (!$user->hasPermission('ver-dashboard')) {
            // Si no tiene dashboard, buscar la primera vista a la que sí tenga acceso
            if ($user->hasPermission('ver-venta-rapida')) {
                return redirect()->route('venta.index');
            } elseif ($user->hasPermission('ver-ventas')) {
                return redirect()->route('ventas.index');
            } elseif ($user->hasPermission('ver-productos')) {
                return redirect()->route('productos.index');
            } elseif ($user->hasPermission('ver-proveedores')) {
                return redirect()->route('proveedores');
            } elseif ($user->hasPermission('ver-usuarios')) {
                return redirect()->route('usuarios.index');
            }
            
            // Si por alguna razón no tiene ningún permiso de vista (caso extremo)
            Auth::logout();
            return redirect()->route('login')->with('error', 'No tienes permisos asignados para navegar en el sistema.');
        }

        // --- CÁLCULO DE ESTADÍSTICAS ---
        
        // Conteo básico
        $stats = [
            'usuarios' => User::count(),
            'productos' => Producto::count(),
            'proveedores' => Proveedor::count(),
            'ventas_mes' => Venta::whereMonth('created_at', Carbon::now()->month)
                                 ->whereYear('created_at', Carbon::now()->year)
                                 ->sum('total'),
        ];

        // Calcular ganancias mensuales
        $ventasDelMes = VentaProducto::whereHas('venta', function($q) {
            $q->whereMonth('created_at', Carbon::now()->month)
              ->whereYear('created_at', Carbon::now()->year);
        })->with('producto.ingresoProducto')->get();

        $gananciaMensual = 0;
        foreach ($ventasDelMes as $vp) {
            if ($vp->producto && $vp->producto->ingresoProducto) {
                $precioCompra = $vp->producto->ingresoProducto->costo_total / $vp->producto->ingresoProducto->cantidad_inicial;
                $precioVenta = $vp->precio_unitario;
                $gananciaUnitaria = max(0, $precioVenta - $precioCompra);
                $gananciaMensual += $gananciaUnitaria * $vp->cantidad;
            }
        }
        $stats['ganancia_mes'] = $gananciaMensual;

        // Distribución de métodos de pago
        $pagoEfectivo = Venta::whereMonth('created_at', Carbon::now()->month)
                             ->whereYear('created_at', Carbon::now()->year)
                             ->where('metodo_pago', 'efectivo')
                             ->count();
        $pagoQR = Venta::whereMonth('created_at', Carbon::now()->month)
                       ->whereYear('created_at', Carbon::now()->year)
                       ->where('metodo_pago', 'qr')
                       ->count();

        // Ventas diarias del mes actual
        $ventasDiarias = Venta::select(
            DB::raw('DAY(created_at) as dia'),
            DB::raw('SUM(total) as total')
        )
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->groupBy(DB::raw('DAY(created_at)'))
        ->orderBy('dia')
        ->get();

        // Completar con 0 para días sin ventas
        $diasEnMes = Carbon::now()->daysInMonth;
        $ventasDiariasData = array_fill(1, $diasEnMes, 0);
        foreach ($ventasDiarias as $venta) {
            $ventasDiariasData[$venta->dia] = (float) $venta->total;
        }

        // Productos más vendidos (Top 5)
        $topProductos = VentaProducto::select('producto_id', DB::raw('SUM(cantidad) as total_vendido'))
            ->with('producto')
            ->groupBy('producto_id')
            ->orderBy('total_vendido', 'desc')
            ->take(5)
            ->get();

        // Tendencia de ventas (Mensual para un año específico)
        $selectedYear = $request->get('year', date('Y'));
        
        $ventasMensuales = Venta::select(
            DB::raw('MONTH(created_at) as mes'),
            DB::raw('SUM(total) as total')
        )
        ->whereYear('created_at', $selectedYear)
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('mes')
        ->get();

        // Inicializamos array de 12 meses
        $chartData = array_fill(1, 12, 0);
        foreach ($ventasMensuales as $venta) {
            $chartData[$venta->mes] = (float) $venta->total;
        }

        // Años disponibles para el selector (desde el primer registro de venta)
        $añosDisponibles = Venta::select(DB::raw('YEAR(created_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year');
            
        if ($añosDisponibles->isEmpty()) {
            $añosDisponibles = collect([date('Y')]);
        }

        return view('administrador.dashboard', compact(
            'user', 
            'stats', 
            'topProductos', 
            'chartData', 
            'selectedYear', 
            'añosDisponibles',
            'pagoEfectivo',
            'pagoQR',
            'ventasDiariasData'
        ));
    }
}