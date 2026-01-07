<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\VentaProducto;
use App\Models\IngresoProducto;
use App\Models\Recibo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::with(['detalles.producto', 'recibo', 'user']);

        // Filtro por fecha
        if ($request->fecha_inicio) {
            $query->whereDate('created_at', '>=', $request->fecha_inicio);
        }
        if ($request->fecha_fin) {
            $query->whereDate('created_at', '<=', $request->fecha_fin);
        }

        // Búsqueda por ID o Usuario
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('id', $request->search)
                  ->orWhereHas('user', function($qu) use ($request) {
                      $qu->where('name', 'LIKE', "%{$request->search}%");
                  });
            });
        }

        $orden = $request->get('orden', 'desc');
        $query->orderBy('created_at', $orden);

        $ventas = $query->paginate(10);

        // Estadísticas
        $stats = [
            'total_hoy' => Venta::whereDate('created_at', Carbon::today())->sum('total'),
            'total_semana' => Venta::whereBetween('created_at', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()])->sum('total'),
            'total_mes' => Venta::whereMonth('created_at', Carbon::now()->month)->sum('total'),
            'transacciones' => Venta::count(),
        ];

        return view('administrador.ventas.index', compact('ventas', 'stats'));
    }

    public function create()
    {
        return view('administrador.ventas.venta');
    }

    public function show(Venta $venta, Request $request)
    {
        $venta->load(['detalles.producto', 'recibo', 'user']);
        
        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'venta' => $venta
            ]);
        }

        return redirect()->route('ventas.index');
    }

    public function buscarProducto(Request $request)
    {
        $term = $request->get('term');
        
        $productos = Producto::where('codigo', $term)
            ->orWhere('nombre', 'LIKE', "%{$term}%")
            ->with(['ingresoProducto'])
            ->get();

        return response()->json($productos->map(function($p) {
            // Calcular stock agregado sumando todos los lotes del producto por nombre
            // Quitamos la restricción de proveedor para que sume todos los reabastecimientos del mismo producto
            $stockAgregado = IngresoProducto::where('nombre_producto', $p->nombre)
                ->sum('cantidad_restante');

            return [
                'id' => $p->id,
                'codigo' => $p->codigo,
                'nombre' => $p->nombre,
                'precio' => $p->precio_venta_unitario,
                'imagen' => $p->imagen ? asset('storage/' . $p->imagen) : asset('img/no-image.png'),
                'stock' => floatval($stockAgregado),
                'unidad_medida' => $p->ingresoProducto->unidad_medida ?? 'Unidades',
            ];
        }));
    }

    public function store(Request $request)
    {
        $request->validate([
            'carrito' => 'required|array|min:1',
            'metodo_pago' => 'required|in:efectivo,qr',
            'total' => 'required|numeric',
            'monto_recibido' => 'required|numeric',
            'vuelto' => 'required|numeric',
        ]);

        try {
            DB::beginTransaction();

            $venta = Venta::create([
                'user_id' => Auth::id(),
                'total' => $request->total,
                'metodo_pago' => $request->metodo_pago,
                'monto_recibido' => $request->monto_recibido,
                'vuelto' => $request->vuelto,
            ]);

            foreach ($request->carrito as $item) {
                VentaProducto::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Descontar stock (Lógica FIFO entre lotes por nombre de producto)
                $producto = Producto::find($item['id']);
                $cantidadPorDescontar = floatval($item['cantidad']);

                // Buscamos todos los lotes activos para este producto (mismo nombre y proveedor)
                $lotesQuery = IngresoProducto::where('nombre_producto', $producto->nombre)
                    ->where('cantidad_restante', '>', 0);
                
                if ($producto->ingresoProducto) {
                    $lotesQuery->where('proveedor_id', $producto->ingresoProducto->proveedor_id);
                }

                $lotes = $lotesQuery->orderBy('fecha_ingreso', 'asc') // FIFO: más antiguo primero
                    ->get();

                foreach ($lotes as $lote) {
                    if ($cantidadPorDescontar <= 0) break;

                    if ($lote->cantidad_restante >= $cantidadPorDescontar) {
                        $lote->cantidad_restante -= $cantidadPorDescontar;
                        $cantidadPorDescontar = 0;
                    } else {
                        $cantidadPorDescontar -= $lote->cantidad_restante;
                        $lote->cantidad_restante = 0;
                    }
                    $lote->save();
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'mensaje' => 'Venta registrada correctamente',
                'venta_id' => $venta->id
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al registrar la venta: ' . $e->getMessage()
            ], 500);
        }
    }

    public function generarRecibo(Request $request)
    {
        $request->validate([
            'venta_id' => 'required|exists:ventas,id',
            'ci_nit' => 'required|string',
            'tipo_documento' => 'required|string',
            'razon_social' => 'required|string',
        ]);

        try {
            $venta = Venta::with(['detalles.producto', 'user'])->findOrFail($request->venta_id);

            // Crear o actualizar el recibo
            $recibo = \App\Models\Recibo::updateOrCreate(
                ['venta_id' => $venta->id],
                [
                    'ci_nit' => $request->ci_nit,
                    'complemento' => $request->complemento,
                    'tipo_documento' => $request->tipo_documento,
                    'razon_social' => $request->razon_social,
                    'recibo_pdf' => '', // Temporal
                ]
            );

            // Generar PDF
            $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('administrador.ventas.recibo_pdf', compact('venta', 'recibo'));
            
            // Convertir a Base64 string
            $pdfContent = base64_encode($pdf->output());
            
            // Guardar el string en la BD
            $recibo->recibo_pdf = $pdfContent;
            $recibo->save();

            return response()->json([
                'success' => true,
                'pdf' => $pdfContent,
                'filename' => "recibo_{$venta->id}.pdf"
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'mensaje' => 'Error al generar recibo: ' . $e->getMessage()
            ], 500);
        }
    }

    public function buscarCliente(Request $request)
    {
        $ci_nit = $request->get('ci_nit');
        
        // Buscar recibos que coincidan con el CI/NIT
        // Usamos una subconsulta para obtener los registros más recientes por CI/NIT y Razón Social
        $clientes = Recibo::select('ci_nit', 'razon_social', 'tipo_documento', 'complemento')
            ->where('ci_nit', 'LIKE', "%{$ci_nit}%")
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($item) {
                return $item['ci_nit'].$item['razon_social'];
            })
            ->take(5);

        if ($clientes->count() > 0) {
            return response()->json([
                'success' => true,
                'clientes' => $clientes->values()
            ]);
        }

        return response()->json([
            'success' => false,
            'mensaje' => 'Cliente no encontrado'
        ]);
    }
}

