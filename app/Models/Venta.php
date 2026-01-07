<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Venta extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'total',
        'metodo_pago',
        'monto_recibido',
        'vuelto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function detalles()
    {
        return $this->hasMany(VentaProducto::class);
    }

    public function recibo()
    {
        return $this->hasOne(Recibo::class);
    }
}
