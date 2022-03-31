<?php

namespace App\Http\Controllers;

use App\Models\Productos;

use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index(){

        $dataProductos = Productos::whereEstatusProducto(1)
        ->whereDeletedProducto(1)
        ->get();

        return view('inventory.indexInventory', compact('dataProductos'));
    }
}
