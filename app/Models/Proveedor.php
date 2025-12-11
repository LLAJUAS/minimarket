<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'proveedores';

    protected $fillable = [
        'nombre_empresa',
        'nombre_contacto',
        'celular',
        'email',
        'direccion',
    ];

    public function ingresosProductos()
    {
        return $this->hasMany(IngresoProducto::class);
    }

    /**
     * Para contar los productos, usamos la relación con ingresos_productos
     * ya que cada registro en esa tabla representa un producto.
     */
    public function productos()
    {
        return $this->ingresosProductos();
    }
}