@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3>Nueva venta</h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url('ventas/venta')}}" method="POST">
            {{csrf_field()}} <!-- Llave de seguridad -->
            
            <div class="row">
                <!-- Cliente -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="cliente" class="form-label">Cliente</label>
                        <select name="idCliente" id="idCliente" class="form-control selectpicker" data-live-search="true">
                            <option value=""> Seleccione un cliente </option>
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
                                    <option value=""> Seleccione un artículo </option>
                                    @foreach($articulos as $articulo)                                      
                                        <option value="{{$articulo->id}}_{{$articulo->stock}}_{{$articulo->ultimo_precio}}">{{$articulo->articulo}}</option>
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

                        <!-- stock -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="pcantidad">Stock</label>
                                <input type="number" disabled name="stock" id="stock" class="form-control">
                            </div>
                        </div>                        

                        <!-- pprecio_venta -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="pprecio_venta">Precio venta</label>
                                <input type="number" disabled name="pprecio_venta" id="pprecio_venta" class="form-control">
                            </div>
                        </div>

                        <!-- descuento -->
                        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                            <div class="form-group">
                                <label for="descuento">Descuento %</label>
                                <input type="number" name="descuento" id="descuento" class="form-control" placeholder="Porcentaje de descuento">
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
                                    <th>Precio de venta</th>
                                    <th>Monto descontado</th> 
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th>TOTAL</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th> <h4 id="total">$ 0.00 </h4> <input type="hidden" name="total_venta" id="total_venta"> </th>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>


                <!-- Botones -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="">
                    <div class="form-group">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button class="btn btn-primary" id="guardar" type="submit">Guardar</button>                                
                        <a href="{{url('ventas/venta')}}" class="btn btn-danger">Cancelar</a>  
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
        $('#guardar').hide();
        $('#pidArticulo').change(mostrarValores);

        function mostrarValores(){
            datosArticulo = document.getElementById('pidArticulo').value.split('_');
            $('#stock').val(datosArticulo[1]);
            $('#pprecio_venta').val(datosArticulo[2]);
            
        }

        function agregar(){
            datosArticulo = document.getElementById('pidArticulo').value.split('_');
            idArticulo = datosArticulo[0];
            articulo = $('#pidArticulo option:selected').text();
            cantidad = $('#pcantidad').val();
            descuento = $('#descuento').val();
            precio_venta = $('#pprecio_venta').val();
            stock = $('#stock').val();

            //valido q no esten vacios los campos
            if(idArticulo!="" && cantidad>0 && descuento!="" && precio_venta!=""){

                if(stock>=cantidad){ //Si el stock es mayor o igual que la cant de la venta, hago la venta
                    descuento = descuento * (cantidad*precio_venta) / 100;
                    subtotal[cont] = (cantidad*precio_venta) - descuento;
                    total = total + subtotal[cont];

                    //Lleno las filas
                    var fila = '<tr class="selected" id="fila'+cont+'"';
                        fila += '<td> este no lo lee no se xq </td>';
                        fila += '<td> <button type="button" class="btn btn-danger" onclick=eliminar('+cont+');> X </button> </td>';
                        fila += '<td> <input type="hidden" name="idArticulo[]" value="'+idArticulo+'"> '+articulo+' </td>';
                        fila += '<td> <input type="number" name="cantidad[]" value="'+cantidad+'"> </td>';                       
                        fila += '<td> <input type="number" name="precio_venta[]" value="'+precio_venta+'"> </td>';
                        fila += '<td> <input type="number" name="descuento[]" value="'+descuento+'"> </td>';
                        fila += '<td> $ '+subtotal[cont]+' </td>';
                        fila += '</tr>';

                    cont++;
                    limpiar();
                    $('#total').html('$ '+total);
                    $('#total_venta').val(total);
                    evaluar();
                    $('#detalles').append(fila);

                }
                else{
                    alert('La cantidad a vender supera el stock del artículo');
                }
                
            }
            else{
                alert("Error al ingresar los detalles de la venta");
            }
        }

        function limpiar(){ //Limpiar inputs
            $('#pcantidad').val("");
            $('#stock').val("");
            $('#descuento').val("");
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
            $('#total_venta').val(total);
            $('#fila' + index).remove();
            evaluar();
        } 


    </script>
@endpush

@endsection