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
}
