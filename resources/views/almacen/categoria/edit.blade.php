@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <h3>Editar categoria: {{$categoria->nombre}}</h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url ('/almacen/categoria/'.$id.'')}}" method="post">
            {{csrf_field()}} <!-- Llave de seguridad -->
            {{method_field('PATCH')}}
            <!-- nombre -->
            <div class="form-group">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" value="{{$categoria->nombre}}" placeholder="Nombre" class="form-control" >
            </div>
            
            <!-- descripcion -->
            <div class="form-group">
                <label for="descripcion" class="form-label">Descripcion</label>
                <input type="text" name="descripcion" value="{{$categoria->descripcion}}" placeholder="Descripcion" class="form-control">
            </div>

            <!-- Botones -->
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{url('almacen/categoria')}}" class="btn btn-danger">Cancelar</a>
            </div>         

        </form>

    </div>
</div>


@endsection