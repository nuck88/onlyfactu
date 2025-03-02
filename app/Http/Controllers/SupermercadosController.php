<?php

namespace App\Http\Controllers;

use App\Models\Supermercado;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Precio;

class SupermercadosController extends Controller
{

    public function index(Request $request){

        $query = $request->input('query');


        $supermercados = Supermercado::all();
        $productos = Producto::all();

        // $precios = Precio::orderBy('id', 'desc')->paginate(5);

        $precios = Precio::with('supermercado', 'producto')
        ->when($query, function ($q) use ($query) {
            return $q->whereHas('producto', function ($queryProducto) use ($query) {
                    $queryProducto->where('nombre', 'LIKE', "%$query%");
                })
                ->orWhereHas('supermercado', function ($querySupermercado) use ($query) {
                    $querySupermercado->where('nombre', 'LIKE', "%$query%");
                });
        })
        ->orderBy('id', 'desc')
        ->paginate(5);
        return view('comparador',compact('supermercados','productos','precios'));
    }

    public function nuevo(Request $request)
    {
        $super = new Supermercado();
        $super->nombre = $request->nombre;

        $super->save();

        return redirect()->back();
    }





}
