<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conceptos extends Model
{
    use HasFactory;
    protected $table = 'conceptos'; // Nombre de la tabla en la base de datos
    protected $fillable = ['nombre',];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

}
