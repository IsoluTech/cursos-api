<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventarios extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_name',
        'codigo_producto',
        'descripcion',
        'cantidad_stock',
        'img_product',
        'precio_producto',
    ];
}
