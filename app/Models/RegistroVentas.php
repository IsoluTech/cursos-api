<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroVentas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_cliente',
        'direccion',
        'numero_telefono',
        'email',
        'documento',
        'total',
        'iva',
        'subtotal',
        'giro',
        'registro_num',
        'documento_path'
    ];
}
