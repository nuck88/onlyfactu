<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gastos extends Model
{
    use HasFactory;

    protected $table = 'gastos';
    protected $fillable = ['gasto', 'notas'];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function concepto()
    {
        return $this->belongsTo(Conceptos::class);
    }
}

