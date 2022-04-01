@extends('layouts.app')

@section('sections', 'Inventario')

@section('content')
<div class="container">

<div class="row">
    <div class="col-md-12">
    <div class="card mb-3">
    <div class="card-body d-flex flex-row justify-content-between align-items-center py-2 px-3">
        <h5 class="card-title mb-0">@yield('sections')</h5>
        <div class="col-sm-4">
                    <input onkeyup="search(this.value);" type="text" placeholder="Buscar producto" class="form-control" />
</div>
        <div class="btn-group" role="group">    
            <a class="btn btn-success" href="/facturas/create"><i class="fa fa-plus"></i></a>
        </div>

    </div>
</div>
    </div>
</div>

    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <th scope="col">#</th>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Numero de parte</th>
                            <th scope="col">Publicado</th>
                            <th scope="col">Precio</th>
                            <th scope="col">Existencia</th>
                            <th scope="col">Acciones</th>
                        </thead>
                        <tbody id="cuerpoTabla">
                            @foreach ($dataProductos as $k => $d)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$d->codigo_producto}}</td>
                                <td>{{$d->nombre_producto}}</td>
                                <td>{{$d->nro_parte_producto}}</td>
                                <td>
                                    @if ($d->publicado_producto == 0)
                                        <input type="checkbox" class="form-check-input" disabled />
                                    @else
                                        <input type="checkbox"  class="form-check-input" disabled checked />
                                    @endif    
                                </td>
                                <td>{{$d->precio_producto}}</td>
                                <td>{{$d->cant_producto}}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group">
                                        <a class="btn btn-outline-warning" href="{{url('products/'.$d->id_producto.'/edit')}}"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-outline-warning" OnClick="obtenerDatosProductos({{$d->id_producto}})" class="btn btn-outline-secondary"><i class="fa fa-minus"></i></a>
                                        <a class="btn btn-outline-danger" href="{{url('products/'.$d->id_producto.'/delete')}}" onclick="return confirm('¿Deseas elimiar el registro?')"><i class="fa fa-trash"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function search(x){
       // $('#cuerpoTabla').append('hola');
        const csrfToken = "{{ csrf_token() }}";  
        
        fetch('/products/queryProducts', {
           method: 'POST',
           body: JSON.stringify({query: x}),
           headers: {
               'content-type': 'application/json',
               'X-CSRF-TOKEN': csrfToken
           } 
       }).then(response => {
           return response.json();
       }).then( data => {
          
        //console.log(data.lista)
        $('#cuerpoTabla').html("");
        var contador = 0
        for(let i in data.lista){
            var table = "";
            var check = "";

            if(data.lista[i].publicado_producto == 0){
                check += '<input type="checkbox" class="form-check-input" disabled />' 
            }else{
                check += '<input type="checkbox" class="form-check-input" disabled checked />'
            }
            contador = parseInt(i)+1
            table += '<tr>'
            table += '<td>'+contador+'</td>'
            table += '<td>'+data.lista[i].codigo_producto+'</td>'
            table += '<td>'+data.lista[i].nombre_producto+'</td>'
            table += '<td>'+data.lista[i].nro_parte_producto+'</td>'
            table += '<td>'+check+'</td>'
            table += '<td>'+data.lista[i].precio_producto+'</td>'
            table += '<td>'+data.lista[i].cant_producto+'</td>'
            table += '<td class="text-center">'
            table += '<div class="btn-group" role="group">'
            table += '<a class="btn btn-outline-warning" href="url(\'products/'+data.lista[i].id_producto+'/edit\')"><i class="fa fa-edit"></i></a>'
            table += '<a class="btn btn-outline-warning" OnClick="obtenerDatosProductos('+data.lista[i].id_producto+')" class="btn btn-outline-secondary"><i class="fa fa-minus"></i></a>'
            table += '<a class="btn btn-outline-danger" href="url(\'products/'+data.lista[i].id_producto+'/delete\')" onclick="return confirm(\'¿Deseas elimiar el registro?\')"><i class="fa fa-trash"></i></a>'
            table += '</div>'
            table += '</td>'
            table += '</tr>'


            $('#cuerpoTabla').append(table);
        }
        


       })
}
    
</script>



<!-- Modal -->
<div class="modal fade" id="exampleModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Descontar productos</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{url('products/discount')}}" method="post">
      @csrf
      <div class="modal-body">
        
        
        <div id="_producto"></div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" disabled id="guardarMinus" class="btn btn-primary">Save changes</button>
      </div>
      </form>
    </div>
  </div>
</div>

<script>

function obtenerDatosProductos(x){
    const csrfToken = "{{ csrf_token() }}";    
    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});

    fetch('/products/obtenerDatosProductos', {
           method: 'POST',
           body: JSON.stringify({id_producto: x}),
           headers: {
               'content-type': 'application/json',
               'X-CSRF-TOKEN': csrfToken
           } 
       }).then(response => {
           return response.json();
       }).then( data => {
          
        console.log(data.lista)

        var p = "";

        p += '<div class="row"><label for="" class="form-label col-sm-4">Producto: '+data.lista[0].nombre_producto+'</label><label for="" class="form-label col-sm-4">Cantidad Actual: '+data.lista[0].cant_producto+'</label></div>';

        p += '<div class="row" ><label class="form-label col-sm-2">Descuento: </label><div class="col-sm-3" id="des"><input id="inputDes" required onkeyup="calculaDisp(this.value, '+data.lista[0].id_producto+')" class="form-control" type="text" name="descuento"></div></div>'
        
        p += '<input type="hidden" name="id_producto" value="'+data.lista[0].id_producto+'">'
        $('#_producto').html(p);
        
    
    
           
       });

       myModal.show();

}
    

function calculaDisp(x, y){
    const csrfToken = "{{ csrf_token() }}";

    fetch('/products/calcular', {
           method: 'POST',
           body: JSON.stringify({id_producto: y, cantidad: x}),
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
            err += '<div class="valid-feedback feedbacksito">Cantidad valida</div>'
            $('#inputDes').addClass('is-valid');
            $('#inputDes').removeClass('is-invalid');
            $('#guardarMinus').prop('disabled', false)
        }else{
            $('.feedbacksito').remove();
            err += '<span class="invalid-feedback feedbacksito" role="alert"><strong>La cantidad debe ser menor a la actual</strong></span>'
            $('#inputDes').addClass('is-invalid');
            $('#inputDes').removeClass('is-valid');
            $('#guardarMinus').prop('disabled', true)
        }

        $('#des').append(err);
        
    
    
           
       });

}
    

    </script>

@endsection