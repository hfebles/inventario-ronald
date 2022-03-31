@extends('layouts.app')

@section('content')


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="form" action="{{url('products/'.$dataProductos[0]->id_producto)}}" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('PATCH')}}
                    <div class="card-header d-flex flex-row justify-content-between align-items-center py-2 px-3">
                        Editar producto 
                        <a class="btn btn-outline-danger" href="{{url('inventory')}}"><i class="fa fa-times"></i></a>
                    </div>

                    <div class="card-body">

                        <div class="row">
                            <label for="" class="form-label col-sm-4">Codigo</label>
                            <label for="" class="form-label col-sm-4">Nombre</label>
                            <label for="" class="form-label col-sm-4">Nro Parte</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <input value="{{isset($dataProductos[0]->codigo_producto)?$dataProductos[0]->codigo_producto:old('codigo_producto') }}" name="codigo_producto" type="text" class="form-control @if ($dataExiste == 1) is-invalid @endif">
                    
                                @if ($dataExiste == 1)
                                
                                    <span class="invalid-feedback" role="alert">
                                        <strong>El codigo ya existe</strong>
                                    </span>
                                @endif  
                            </div>
                            <div class="col-sm-4">
                                <input value="{{isset($dataProductos[0]->nombre_producto)?$dataProductos[0]->nombre_producto:old('nombre_producto') }}" name="nombre_producto" type="text" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input value="{{isset($dataProductos[0]->nro_parte_producto)?$dataProductos[0]->nro_parte_producto:old('nro_parte_producto') }}" name="nro_parte_producto" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="" class="form-label col-sm-4">Cantidad</label>
                            <label for="" class="form-label col-sm-4">Precio</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <input value="{{isset($dataProductos[0]->cant_producto)?$dataProductos[0]->cant_producto:old('cant_producto') }}" name="cant_producto" type="text" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input value="{{isset($dataProductos[0]->precio_producto)?$dataProductos[0]->precio_producto:old('precio_producto') }}" name="precio_producto" type="text" class="form-control">
                            </div>

                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4">
                                <button class="btn btn-outline-success" typy="submit">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
