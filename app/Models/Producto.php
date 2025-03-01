<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $table = 'productos';
    protected $fillable = ['nombre', 'cantidad'];

    // public function precios()
    // {
    //     return $this->hasMany(Precio::class);
    // }

    // public static function crearConPrecios($nombre, $marca = null)
    // {
    //     $producto = self::create(['nombre' => $nombre, 'marca' => $marca]);

    //     $supermercados = Supermercado::all();
    //     foreach ($supermercados as $supermercado) {
    //         Precio::create([
    //             'producto_id' => $producto->id,
    //             'supermercado_id' => $supermercado->id,
    //             'precio' => null,
    //         ]);
    //     }

    //     return $producto;
    // }
}
