@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h3> Lstado de articulos <a href="{{url('almacen/articulo/create')}}" class="btn btn-primary">Nuevo</a> </h3>
        @include('almacen.articulo.search')
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th> # </th>
                    <th> Nombre </th>
                    <th> Codigo </th>
                    <th> Categoria </th>
                    <th> Stock </th>
                    <th> Imagen </th>
                    <th> Estado </th>
                    <th> Fecha de registro </th>
                    <th> Opciones </th>
                </thead>
                <tbody>
                    @foreach($articulos as $art)
                        <tr>                           
                            <td>{{ ($articulos->currentpage()-1) * $articulos->perpage() + $loop->index + 1 }}</td>
                            <td>{{$art->nombre}}</td>
                            <td>{{$art->codigo}}</td>
                            <td>{{$art->categoria}}</td>                           
                            <td>{{$art->stock}}</td>
                            <td>                                
                                <img src="{{asset('imagenes/articulos/'.$art->imagen.'')}}" class="img-fluid img-thumbnail" width="100" heigh="100">                         
                            </td>
                            <td>{{$art->estado}}</td>
                            <td>{{$art->fecha_registro}}</td>
                            <td>
                                <a href="{{url ('/almacen/articulo/'.$art->id.'/edit')}}" class="btn btn-info"> Editar </a>
                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-{{$art->id}}">
                                    Eliminar
                                </button>      
                            </td>
                        </tr>
                        @include('almacen.articulo.modal')
                    @endforeach
                </tbody>
            </table>
        </div>
        {{$articulos->render()}}
    </div>
</div>

@endsection