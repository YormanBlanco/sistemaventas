@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lstado de ingresos <a href="{{url('compras/ingreso/create')}}" class="btn btn-primary">Nuevo</a> </h3>
        @include('compras.ingreso.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th> # </th>
                    <th>Fecha de registro</th>
                    <th>Proveedor</th>
                    <th>Comprobante</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th> Opciones </th>
                </thead>
                <tbody>
                    @foreach($ingresos as $in)
                        <tr>                           
                            <td>{{ ($ingresos->currentpage()-1) * $ingresos->perpage() + $loop->index + 1 }}</td>
                            <td>{{$in->fecha_hora}}</td>
                            <td>{{$in->nombre}}</td>
                            <td>{{$in->tipo_comprobante.': '.$in->serie_comprobante.'-'.$in->num_comprobante}}</td>
                            <td>{{$in->impuesto}}</td>
                            <td>{{$in->total}}</td>
                            <td>{{$in->estado}}</td>
                            <td>
                                
                                <a href="{{url ('/compras/ingreso/'.$in->id.'')}}" class="btn btn-primary">Detalles</a>

                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$in->id}}">
                                    Anular
                                </button>

                            </td>
                        </tr>
                        @include('compras.ingreso.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$ingresos->render()}}
    </div>
</div>


@endsection