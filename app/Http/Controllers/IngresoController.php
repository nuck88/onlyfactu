<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Conceptos;
use App\Models\Ingresos;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index(Request $request)
    {
        $mes = $request->input('mes'); // Capturamos el mes del formulario

        if ($mes) {
            $ingresos = Ingresos::whereMonth('created_at', $mes)->paginate(5);;
        } else {
            $ingresos = Ingresos::orderBy('id', 'desc')->paginate(5);
        }

        $categorias = Categoria::where('id', 2)->get(); // Obtiene una colección (incluso si solo hay un resultado).

        $conceptos = Conceptos::where('categoria_id', 2)->get();

        return view('ingresos', compact('ingresos', 'mes', 'categorias' , 'conceptos'));
    }

    public function delete($id)
    {
        $ingresos = Ingresos::find($id);

        if (!$ingresos) {
            return redirect()->back()->with('error', 'Categoría no encontrada.');
        }

        $ingresos->delete();
        return redirect()->back()->with('success', 'Categoría eliminada correctamente.');

        return view('ingresos');

    }

    public function nuevo(Request $request)
    {
        $ingresos = new ingresos();
        $ingresos->categoria_id =  $request->categoria_id;
        $ingresos->concepto_id = $request->concepto_id;
        $ingresos->importe = $request->importe;
        $ingresos->concepto = $request->concepto;
        $ingresos->save();
        return redirect()->back();
    }
}
