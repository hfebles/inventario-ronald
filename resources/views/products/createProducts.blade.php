@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <form class="form" action="{{url('products')}}" method="post" enctype="multipart/form-data">
                @csrf
                    <div class="card-header d-flex flex-row justify-content-between align-items-center py-2 px-3">
                        Registrar 
                        <a class="btn btn-outline-danger" href="{{url('inventory')}}"><i class="fa fa-times"></i></a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <label for="" class="form-label col-sm-4">Codigo</label>
                            <label for="" class="form-label col-sm-4">Nombre</label>
                            <label for="" class="form-label col-sm-4">Nro Parte</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-4" id="des">
                                <input name="codigo_producto" id="codigo_producto" onkeyup="validarCodigo(this.value)" type="text" class="form-control">
                                
                            </div>
                            <div class="col-sm-4">
                                <input name="nombre_producto" type="text" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input name="nro_parte_producto" type="text" class="form-control">
                            </div>
                        </div>

                        <div class="row mt-3">
                            <label for="" class="form-label col-sm-4">Cantidad</label>
                            <label for="" class="form-label col-sm-4">Precio</label>
                        </div>
                        <div class="row">
                            <div class="col-sm-4">
                                <input name="cant_producto" type="text" class="form-control">
                            </div>
                            <div class="col-sm-4">
                                <input name="precio_producto" type="text" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-sm-4">
                                <button class="btn btn-outline-success" disabled id="guardarProducto" typy="submit">Guardar</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    
function validarCodigo(x){
    const csrfToken = "{{ csrf_token() }}";

    fetch('products/valida-codigo', {
           method: 'POST',
           body: JSON.stringify({codigo: x}),
           headers: {
               'content-type': 'application/json',
               'X-CSRF-TOKEN': csrfToken
           } 
       }).then(response => {
           return response.json();
       }).then( data => {
          
        console.log(data.success)

        var err= '';

        if(data.success == true){
            
            $('.feedbacksito').remove();
            err += '<div class="valid-feedback feedbacksito">Codigo valida</div>'
            $('#codigo_producto').addClass('is-valid');
            $('#codigo_producto').removeClass('is-invalid');
            $('#guardarProducto').prop('disabled', false)
        }else if(data.success == "vacio"){
            $('.feedbacksito').remove();
            err += '<span class="invalid-feedback feedbacksito" role="alert"> <strong>El codigo no puede estar vacio</strong> </span>'
            $('#codigo_producto').addClass('is-invalid');
            $('#codigo_producto').removeClass('is-valid');
            $('#guardarProducto').prop('disabled', true)
        }else{
            $('.feedbacksito').remove();
            err += '<span class="invalid-feedback feedbacksito" role="alert"> <strong>El codigo ya existe</strong> </span>'
            $('#codigo_producto').addClass('is-invalid');
            $('#codigo_producto').removeClass('is-valid');
            $('#guardarProducto').prop('disabled', true)
        }

        

        
        $('#des').append(err);
        
    
    
           
       });

}
</script>
@endsection