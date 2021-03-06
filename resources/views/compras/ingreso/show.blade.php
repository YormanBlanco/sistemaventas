@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

            
        <div class="row">
                <!-- Proveedor -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label for="proveedor" class="form-label">Proveedor</label>
                        <h4>{{$ingreso->nombre}}</h4>
                    </div>
                </div>

                <!-- tipo_comprobante -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="tipo_comprobante" class="form-label">Tipo de comprobante</label>
                        <h4>{{$ingreso->tipo_comprobante}}</h4>
                    </div>
                </div>

                <!-- serie_comprobante -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="serie_comprobante" class="form-label">Serie del comprobante</label>
                        <h4>{{$ingreso->serie_comprobante}}</h4>
                    </div>
                </div>

                <!-- num_comprobante -->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="num_comprobante" class="form-label">Número del comprobante</label>
                        <h4>{{$ingreso->num_comprobante}}</h4>
                    </div>
                </div>
            </div>
            

            <div class="row">

                <div class="panel panel-primary">
                    <div class="panel-body">


                        <!-- Tabla -->
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                            <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                                <thead style="background-color:#A9D0F5">
                                    <th>Artículo</th>
                                    <th>Cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio venta</th>
                                    <th>Subtotal</th>
                                </thead>
                                <tfoot>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th> <h4 id="total">$ {{$ingreso->total}} </h4> </th>
                                </tfoot>
                                <tbody>
                                    @foreach($detalles as $det)
                                        <tr> 
                                            <td>{{$det->articulo}}</td>
                                            <td>{{$det->cantidad}}</td>
                                            <td>{{$det->precio_compra}}</td>
                                            <td>{{$det->precio_venta}}</td>
                                            <td>{{$det->cantidad * $det->precio_compra}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>

                <!-- Botones -->
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">
                    <div class="form-group">                               
                        <a href="{{url('compras/ingreso')}}" class="btn btn-success">Entendido</a>  
                    </div>   
                </div>
                
            </div> 
        </div>    
    </div>     
</div>


@endsection