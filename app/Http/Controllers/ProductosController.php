<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Supermercado;
use App\Models\Precio;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function index(Request $request)
    {
        $producto = new Producto();
        $producto->nombre = $request->nombre;
        $producto->cantidad = $request->cantidad;


        $producto->save();

        return redirect()->back()->with('success', 'Producto creado exitosamente.');
    }
}

