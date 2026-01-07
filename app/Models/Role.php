<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // 1. Importar SoftDeletes

class Role extends Model
{
    use HasFactory, SoftDeletes; // 2. Añadir el trait SoftDeletes

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'nombre_rol', // 3. Campo asignable masivamente
    ];

    /**
     * 4. Definir la relación muchos a muchos con el modelo User.
     * Un rol puede ser asignado a muchos usuarios.
     */
    public function users()
    {
        // Esta es la relación inversa a la del modelo User.
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}