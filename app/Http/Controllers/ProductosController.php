<?php

namespace App\Http\Controllers;
use App\Models\Productos;

use Illuminate\Http\Request;

class ProductosController extends Controller
{
    public function create(){

        $dataExiste = 0;
        return view('products.createProducts', compact('dataExiste'));
    }

    public function store(Request $request){

        $data = $request->except('_token');

        $data = request()->except('_token', '_method');        
        $validar = Productos::where('codigo_producto','like','%'.$data['codigo_producto'].'%')->get();

       if (count($validar) > 0){

            $dataExiste = 1;
            return view('products.createProducts', compact('dataExiste'));
       }else{
        Productos::insert($data);
        return redirect('inventory');
       }   
    }

    public function edit($id_producto){

        $dataProductos = Productos::whereIdProducto($id_producto)
        ->whereEstatusProducto(1)
        ->whereDeletedProducto(1)
        ->get();

        //return response()->json($dataProductos);
        $dataExiste = 0;
        return view('products.editPRoducts', compact('dataProductos','dataExiste'));
    }

    public function update(Request $request, $id_producto){

        $data = request()->except('_token', '_method');        
        $validar = Productos::where('codigo_producto','like','%'.$data['codigo_producto'].'%')->get();

       if (count($validar) > 0){
        if($validar[0]->id_producto != $id_producto){
            $dataProductos = Productos::whereIdProducto($id_producto)
            ->whereEstatusProducto(1)
            ->whereDeletedProducto(1)
            ->get();

            $dataExiste = 1;
            return view('products.editPRoducts', compact('dataProductos', 'dataExiste'));
        }else{
            Productos::whereIdProducto($id_producto)->update($data);
            return redirect('inventory');
        }
       }else{
        Productos::whereIdProducto($id_producto)->update($data);
        return redirect('inventory');
       }       
    }

    public function deleteProduct($id_producto){
        
        Productos::whereIdProducto($id_producto)->update(['estatus_producto'=>0]);        
        return redirect('inventory');
    }

    public function discountProduct(Request $request){

        $data = $request->except('_token');
        $cantidadActual = Productos::select('cant_producto')->whereIdProducto($data['id_producto'])->get();
        $guardarCantidad = $cantidadActual[0]->cant_producto - $data['descuento'];
        Productos::whereIdProducto($data['id_producto'])->update(['cant_producto'=>$guardarCantidad]);
        return redirect('inventory');
    }   

    public function obtenerDatosProductos(Request $request){

        $id_producto = $request->id_producto;
        if(isset($id_producto)){
            $dataProductos = Productos::whereIdProducto($id_producto)
            ->whereEstatusProducto(1)
            ->whereDeletedProducto(1)
            ->get();
            return response()->json(
                [
                    'lista' => $dataProductos,
                    'success' => true
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    public function calcularProductos(Request $request){

        $cantidad = $request->cantidad; 
        $cantidadActual = Productos::select('cant_producto')->whereIdProducto( $request->id_producto)->get();
        if($cantidad > $cantidadActual[0]->cant_producto){
            return response()->json(
                [
                    'mensaje' => 'La cantidad no puede ser mayor a la actual',
                    'success' => false
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }


        
    }


    public function validarCodigo(Request $request){

        $codigo = $request->codigo; 

        if($codigo == ""){
            return response()->json(
                [
                    'success' => 'vacio'
                ]
            );
        }else{
            $validar = Productos::where('codigo_producto','=',$codigo)->get();
        }
        

        //return response()->json($request);
        
        if(count($validar) > 0){
            return response()->json(
                [
                    'mensaje' => 'La cantidad no puede ser mayor a la actual',
                    'success' => false
                ]
            );
        }else{
            return response()->json(
                [
                    'success' => true,
                ]
            );
        }
    }
}
