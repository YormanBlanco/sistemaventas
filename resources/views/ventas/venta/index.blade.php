@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lstado de ventas <a href="{{url('ventas/venta/create')}}" class="btn btn-primary">Nuevo</a> </h3>
        @include('ventas.venta.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th> # </th>
                    <th>Fecha de registro</th>
                    <th>Cliente</th>
                    <th>Comprobante</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th> Opciones </th>
                </thead>
                <tbody>
                    @foreach($ventas as $v)
                        <tr>                           
                            <td>{{ ($ventas->currentpage()-1) * $ventas->perpage() + $loop->index + 1 }}</td>
                            <td>{{$v->fecha_hora}}</td>
                            <td>{{$v->nombre}}</td>
                            <td>{{$v->tipo_comprobante.': '.$v->serie_comprobante.'-'.$v->num_comprobante}}</td>
                            <td>{{$v->impuesto}}</td>
                            <td>{{$v->total_venta}}</td>
                            <td>{{$v->estado}}</td>
                            <td>
                                
                                <a href="{{url ('/ventas/venta/'.$v->id.'')}}" class="btn btn-primary">Detalles</a>

                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$v->id}}">
                                    Anular
                                </button>

                            </td>
                        </tr>
                        @include('ventas.venta.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$ventas->render()}}
    </div>
</div>


@endsection