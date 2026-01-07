<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        'venta_id',
        'ci_nit',
        'complemento',
        'tipo_documento',
        'razon_social',
        'recibo_pdf',
    ];

    public function venta()
    {
        return $this->belongsTo(Venta::class);
    }
}
