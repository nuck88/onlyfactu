<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
    use HasFactory;

    protected $fillable = ['producto_id', 'supermercado_id', 'precio'];

     public function producto()
     {
         return $this->belongsTo(Producto::class);
     }

     public function supermercado()
     {
         return $this->belongsTo(Supermercado::class);
     }
}
