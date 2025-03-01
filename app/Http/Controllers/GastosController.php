<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Conceptos;
use Illuminate\Http\Request;
use App\Models\Gastos;
use Carbon\Carbon;
use App\Models\Ingresos;


class GastosController extends Controller
{
    public function index()
    {

        $gastos = Gastos::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('gasto');

        $ingresos = Ingresos::whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('importe');


        $balance = $ingresos - $gastos;

        $categorias = Categoria::where('id', 2)->get();

        $conceptos = Conceptos::where('categoria_id', 2)->get();

        return view('dashboard', compact('gastos', 'ingresos', 'balance', 'categorias', 'conceptos'));
    }
    public function gastos(Request $request)
    {

        $mes = $request->input('mes'); // Capturamos el mes del formulario

        if ($mes) {

            $gastos = Gastos::whereMonth('created_at', $mes)
                ->with(['categoria', 'concepto']) // Trae los nombres en la consulta
                ->get();
        } else {
            $gastos = Gastos::with(['categoria', 'concepto'])
                ->orderBy('id', 'desc')
                ->paginate(5);
        }

            $categorias = Categoria::all();
            $conceptos = Conceptos::all();
        return view('gastos', compact('gastos','categorias', 'conceptos'));
    }
    public function delete($id)
    {
        $gastos = Gastos::find($id);

        if (!$gastos) {
            return redirect()->back()->with('error', 'Gasto no encontrado');
        }

        $gastos->delete();
        return redirect()->back()->with('success', 'Categoria eliminada');
    }

    public function nuevo(Request $request)
    {


        // $request->validate([
        //     'categoria_id' => 'required|exists:categorias,id',
        //     'concepto_id' => 'required|exists:categorias,id',
        // ]);

        $gastos = new Gastos();
        $gastos->categoria_id = $request->categoria_id;
        $gastos->concepto_id = $request->concepto_id;
        $gastos->gasto = $request->importe;
        $gastos->notas = $request->notas;
        $gastos->save();

        return redirect()->back();
    }
}
