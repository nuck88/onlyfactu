<?php

namespace App\Http\Controllers;

use App\Models\Precio;
use Illuminate\Http\Request;

class PreciosController extends Controller
{
    public function nuevo(Request $request){
        $compa = new Precio();
        $compa->supermercado_id	= $request->supermercado_id;
        $compa->producto_id = $request->producto_id;
        $compa->precio = $request->precio;

        $compa->save();

        return redirect()->back();
    }

    public function delete($id){
        $compa = Precio::find($id);
        $compa->delete();

        return redirect()->back();
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:precios,id',
            'precio' => 'required|numeric|min:0',
        ]);

        $precio = Precio::find($request->id);
        $precio->precio = $request->precio;
        $precio->save();

        return redirect()->back()->with('success', 'Precio actualizado correctamente');
    }
}
