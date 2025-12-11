<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Producto extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = ['ingreso_producto_id', 'subcategoria_id', 'codigo', 'nombre', 'precio_venta_unitario', 'imagen'];
    
    public function ingresoProducto() { return $this->belongsTo(IngresoProducto::class); }
    
    // Un producto pertenece a una subcategoría
    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class);
    }
    
    // Accesor para obtener la categoría fácilmente si es necesario
    public function getCategoriaAttribute()
    {
        return $this->subcategoria?->categoria;
    }
}