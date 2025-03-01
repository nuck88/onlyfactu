<?php

namespace App\Http\Controllers;

use App\Models\Supermercado;
use Illuminate\Http\Request;
use App\Models\Producto;
use App\Models\Precio;

class SupermercadosController extends Controller
{

    public function index(){
        $supermercados = Supermercado::all();
        $productos = Producto::all();
        $precios = Precio::orderBy('id', 'desc')->paginate(5);
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
