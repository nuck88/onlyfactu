<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categoria;

class CategoriaController extends Controller
{



    public function index()
    {
        $categorias = Categoria::orderBy('id', 'desc')->paginate(5);
        return view('categorias',  compact('categorias'));
    }
    public function delete($id) //Borrar datos
    {
        $categoria = Categoria::find($id);

        if (!$categoria) {
            return redirect()->back()->with('error', 'Categoría no encontrada.');
        }

        $categoria->delete();
        return redirect()->back()->with('success', 'Categoría eliminada correctamente.');
    }
    public function nuevo(Request $request)
    {
        $categoria = new Categoria();
        $categoria->nombre =  $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->save();
        return redirect()->back();
    }



}
