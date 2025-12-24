<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subcategoria extends Model
{
    use HasFactory;
    protected $fillable = ['nombre', 'categoria_id'];

    // Una subcategoría pertenece a una categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Una subcategoría tiene muchos productos
    public function productos()
    {
        return $this->hasMany(Producto::class);
    }
}