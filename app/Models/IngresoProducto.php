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
     * Los atributos que son asignables masivamente.
     * @var array
     */
    protected $fillable = [
        'proveedor_id',
        'nombre_producto',
        'cantidad_inicial',
        'cantidad_restante',
        'costo_total',
        'fecha_ingreso',
        'numero_factura',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * @var array
     */
    protected $casts = [
        'fecha_ingreso' => 'date',
        'cantidad_inicial' => 'integer',
        'cantidad_restante' => 'integer',
        'costo_total' => 'decimal:2',
    ];

    /**
     * Obtener el proveedor asociado a este ingreso.
     */
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    /**
     * Obtener el producto de detalle creado a partir de este ingreso.
     * Relación uno a uno.
     */
    public function productoDetalle()
    {
        return $this->hasOne(Producto::class, 'ingreso_producto_id');
    }
}