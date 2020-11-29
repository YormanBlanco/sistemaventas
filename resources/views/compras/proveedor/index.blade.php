@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lstado de proveedores <a href="{{url('compras/proveedor/create')}}" class="btn btn-primary">Nuevo</a> </h3>
        @include('compras.proveedor.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th> # </th>
                    <th>Nombre</th>
                    <th>Documento de identidad</th>
                    <th>Telefono</th>
                    <th>Email</th>
                    <th>Fecha de registro</th>
                    <th> Opciones </th>
                </thead>
                <tbody>
                    @foreach($personas as $per)
                        <tr>                           
                            <td>{{ ($personas->currentpage()-1) * $personas->perpage() + $loop->index + 1 }}</td>
                            <td>{{$per->nombre}}</td>
                            <td>{{$per->tipo_documento}}: {{$per->num_documento}}</td>
                            <td>{{$per->telefono}}</td>
                            <td>{{$per->email}}</td>
                            <td>{{$per->fecha_registro}}</td>
                            <td>
                                <a href="{{url ('/compras/proveedor/'.$per->id.'/edit')}}" class="btn btn-info">Editar</a>

                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$per->id}}">
                                    Eliminar
                                </button>

                            </td>
                        </tr>
                        @include('compras.proveedor.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$personas->render()}}
    </div>
</div>


@endsection