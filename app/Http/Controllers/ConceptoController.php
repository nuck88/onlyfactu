<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Conceptos;
use App\Models\Categoria;

class ConceptoController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        // Consulta con búsqueda y paginación
        $concepto = Conceptos::with('categoria')
            ->when($query, function ($q) use ($query) {
                return $q->where('nombre', 'LIKE', "%$query%");
            })
            ->orderBy('id', 'desc')
            ->paginate(5);

        $categorias = Categoria::all(); // Obtener todas las categorías

        return view('conceptos', compact('concepto', 'categorias', 'query'));
    }

    public function delete($id)
    {
        $concepto = Conceptos::find($id);

        if (!$concepto) {
            return redirect()->back()->with('error', 'Categoría no encontrada.');
        }

        $concepto->delete();
        return redirect()->back()->with('success', 'Categoría eliminada correctamente.');
    }

    public function nuevo(Request $request)


    {
        $request->validate([
            'categoria_id' => 'required|exists:categorias,id',
            'nombre' => 'required|string|max:255',
        ]);

        $concepto = new Conceptos();
        $concepto->categoria_id = $request->categoria_id;
        $concepto->nombre = $request->nombre;
        $concepto->save();

        return redirect()->back();
    }

    public function obtenerPorCategoria($categoria_id)
    {
        $conceptos = Conceptos::where('categoria_id', $categoria_id)->get();
        return response()->json($conceptos);
    }
}
