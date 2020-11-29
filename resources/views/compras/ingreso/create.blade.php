@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3>Nuevo ingreso</h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url('compras/ingreso')}}" method="POST">
            {{csrf_field()}} <!-- Llave de seguridad -->
            
            <div class="row">
                <!-- Proveedor -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <select name="idProveedor" id="idProveedor" class="form-control selectpicker" data-live-search="true">
                            @foreach($personas as $persona)
                                <option value="{{$persona->id}}">{{$persona->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- tipo_comprobante -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="tipo_comprobante" class="form-label">Tipo de comprobante</label>
                        <select name="tipo_comprobante" id="tipo_comprobante" class="form-control">
                            <option value="Boleta">Boleta</option>
                            <option value="Factura">Factura</option>
                            <option value="Ticket">Ticket</option>
                        </select>
                    </div>
                </div>

                <!-- serie_comprobante -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="serie_comprobante" class="form-label">Serie del comprobante</label>
                        <input type="text" name="serie_comprobante" value="{{old('serie_comprobante')}}" placeholder="Serie de comprobante" class="form-control">
                    </div>
                </div>

                <!-- num_comprobante -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="num_comprobante" class="form-label">Número del comprobante</label>
                        <input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" placeholder="Número de comprobante" class="form-control">
                    </div>
                </div>
            </div>
            

            <div class="row">

                <div class="panel panel-primary">
                    <div class="panel-body">

                        <!-- pidArticulo -->
                        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                            <div class="form-group">
                                <label>Articulo</label>
                                <select name="pidArticulo" id="pidArticulo" class="form-control selectpicker" data-live-search="true">
                                    @foreach($articulos as $articulo)
                                        <option value="{{$articulo->id}}">{{$articulo->articulo}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- pcantidad -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="pcantidad">Cantidad</label>
                                <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad">
                            </div>
                        </div>

                        <!-- pprecio_compra -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="pprecio_compra">Precio de compra</label>
                                <input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="Precio de compra">
                            </div>
                        </div>

                        <!-- pprecio_venta -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="pprecio_venta">Precio de venta</label>
                                <input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="Precio de venta">
                            </div>
                        </div>

                        <!-- Button Agregar detalle-->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                            </div>
                        </div>

                        <!-- Tabla -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5">
                                    <th>Opciones</th>
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio venta</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th> <h4 id="total">$ 0.00 </h4> </th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


                <!-- Botones -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button class="btn btn-primary" id="guardar" type="submit">Guardar</button>                                
                        <a href="{{url('compras/ingreso')}}" class="btn btn-danger">Cancelar</a>  
                    </div>   
                </div>
            </div>      
        </form>
    </div>
</div>

@push('scripts')
    <script>

        $(document).ready(function(){ //Capturo el click al boton agregar
            $('#bt_add').click(function(){
                agregar(); //Llamo ala function agregar para agregar a la tabla
            }); 
        }); 

        total = 0;
        var cont = 0;
        subtotal = [];

        function agregar(){
            idArticulo = $('#pidArticulo').val();
            articulo = $('#pidArticulo option:selected').text();
            cantidad = $('#pcantidad').val();
            precio_compra = $('#pprecio_compra').val();
            precio_venta = $('#pprecio_venta').val();

            //valido q no esten vacios los campos
            if(idArticulo!="" && cantidad>0 && precio_compra!="" && precio_venta!=""){
                subtotal[cont] = (cantidad*precio_compra);
                total = total + subtotal[cont];

                //Lleno las filas
                var fila = '<tr class="selected" id="fila'+cont+'"';
                    fila += '<td> este no lo lee no se xq </td>';
                    fila += '<td> <button type="button" class="btn btn-danger" onclick=eliminar('+cont+');> X </button> </td>';
                    fila += '<td> <input type="hidden" name="idArticulo[]" value="'+idArticulo+'"> '+articulo+' </td>';
                    fila += '<td> <input type="number" name="cantidad[]" value="'+cantidad+'"> </td>';
                    fila += '<td> <input type="number" name="precio_compra[]" value="'+precio_compra+'"> </td>';
                    fila += '<td> <input type="number" name="precio_venta[]" value="'+precio_venta+'"> </td>';
                    fila += '<td> $ '+subtotal[cont]+' </td>';
                    fila += '</tr>';


                cont++;
                limpiar();
                $('#total').html('$ '+total);
                evaluar();
                $('#detalles').append(fila);
            }
            else{
                alert("Error al ingresar los detalles del artículo");
            }
        }

        function limpiar(){ //Limpiar inputs
            $('#pcantidad').val("");
            $('#pprecio_compra').val("");
            $('#pprecio_venta').val("");
        }

        function evaluar(){
            if(total>0){
                $('#guardar').show();
            }else{
                $('#guardar').hide();
            }
        }

        function eliminar(index){
            total = total-subtotal[index];
            $('#total').html('$ '+total);
            $('#fila' + index).remove();
            evaluar();
        } 


    </script>
@endpush

@endsection