@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
        <h3>Editar articulo: {{$articulo->nombre}}  </h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url ('/almacen/articulo/'.$id.'')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}} <!-- Llave de seguridad -->
            {{method_field('PATCH')}}
            
            <!-- nombre -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" required value="{{$articulo->nombre}}">
                </div>
            </div>
            <!-- categoria -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="idCategoria" class="form-label">Categoria</label>
                    <select name="idCategoria" class="form-control">
                        @foreach($categorias as $cat)
                            @if($cat->id == $articulo->idCategoria)
                                <option value="{{$cat->id}}" selected>{{$cat->nombre}}</option>
                                @else
                                    <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- codigo -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="codigo" class="form-label">Codigo</label>
                    <input type="text" name="codigo" class="form-control" value="{{$articulo->codigo}}">
                </div>
            </div>
            <!-- stock -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" name="stock" class="form-control" required value="{{$articulo->stock}}">
                </div>
            </div>
            <!-- descripcion -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" name="descripcion"  class="form-control" value="{{$articulo->descripcion}}">
                </div>
            </div>
            <!-- Imagen -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">                  
                    <label for="imagen" class="form-label">Imagen</label> 
                    @if($articulo != "")   
                        <img src="{{asset('imagenes/articulos/'.$articulo->imagen.'')}}" class="img-fluid img-thumbnail" width="300" heigh="300">
                    @endif            
                    <input type="file" accept="image/*" name="imagen" value="{{old('imagen')}}" class="form-control">
                    
                </div>
            </div>

            <!-- Botones -->
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <a href="{{url('almacen/articulo')}}" class="btn btn-danger">Cancelar</a>
            </div>         

        </form>

    </div>
</div>


@endsection