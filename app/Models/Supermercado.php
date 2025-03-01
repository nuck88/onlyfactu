<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supermercado extends Model
{
    use HasFactory;

    protected $table = 'supermercados'; // Especifica el nombre exacto de la tabla
    protected $fillable = ['nombre'];


    // public function precios()
    // {
    //     return $this->hasMany(Precio::class);
    // }
}
