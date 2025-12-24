<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IngresoProducto extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ingresos_productos'; 

    /**
     * Atributos asignables masivamente
     */
    protected $fillable = [
        'proveedor_id',
        'nombre_producto',
        'cantidad_inicial',
        'cantidad_restante',
        'costo_total',
        'fecha_ingreso',
        'fecha_vencimiento_lote', // 👈 NUEVO
        'numero_factura',
    ];

    /**
     * Casts de atributos
     */
    protected $casts = [
        'fecha_ingreso' => 'date',
        'fecha_vencimiento_lote' => 'date', // 👈 NUEVO
        'cantidad_inicial' => 'integer',
        'cantidad_restante' => 'integer',
        'costo_total' => 'decimal:2',
    ];

    /**
     * Relación: un ingreso pertenece a un proveedor
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Relación: un ingreso genera un producto
     */
    public function productoDetalle()
    {
        return $this->hasOne(Producto::class, 'ingreso_producto_id');
    }
}
