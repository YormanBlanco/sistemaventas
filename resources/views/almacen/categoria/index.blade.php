@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lstado de categorias <a href="{{url('almacen/categoria/create')}}" class="btn btn-primary">Nuevo</a> </h3>
        @include('almacen.categoria.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th> # </th>
                    <th> Nombre </th>
                    <th> Descripcion </th>
                    <th> Fecha de registro </th>
                    <th> Opciones </th>
                </thead>
                <tbody>
                    @foreach($categorias as $cat)
                        <tr>                           
                            <td>{{ ($categorias->currentpage()-1) * $categorias->perpage() + $loop->index + 1 }}</td>
                            <td>{{$cat->nombre}}</td>
                            <td>{{$cat->descripcion}}</td>
                            <td>{{$cat->fecha_registro}}</td>
                            <td>
                                <a href="{{url ('/almacen/categoria/'.$cat->id.'/edit')}}" class="btn btn-info">Editar</a>

                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$cat->id}}">
                                    Eliminar
                                </button>

                            </td>
                        </tr>
                        @include('almacen.categoria.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$categorias->render()}}
    </div>
</div>


@endsection