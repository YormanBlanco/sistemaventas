@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3>Nuevo Articulo</h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url('almacen/articulo')}}" method="POST" enctype="multipart/form-data">
            {{csrf_field()}} <!-- Llave de seguridad -->

            <!-- nombre -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" class="form-control" required value="{{old('nombre')}}">
                </div>
            </div>
            <!-- categoria -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="idCategoria" class="form-label">Categoria</label>
                    <select name="idCategoria" class="form-control">
                        @foreach($categorias as $cat)
                            <option value="{{$cat->id}}">{{$cat->nombre}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <!-- codigo -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="codigo" class="form-label">Codigo</label>
                    <input type="text" name="codigo" placeholder="Codigo" class="form-control" value="{{old('codigo')}}">
                </div>
            </div>
            <!-- stock -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="text" name="stock" placeholder="Stock" class="form-control" required value="{{old('stock')}}">
                </div>
            </div>
            <!-- descripcion -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <input type="text" name="descripcion" placeholder="Descripcion" class="form-control" value="{{old('descripcion')}}">
                </div>
            </div>
            <!-- Imagen -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">                  
                    <label for="imagen" class="form-label">Imagen</label>   
                    <input type="file" accept="image/*" name="imagen" value="{{old('imagen')}}" class="form-control">
                </div>
            </div>

            <!-- Botones -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>                                
                    <a href="{{url('almacen/articulo')}}" class="btn btn-danger">Cancelar</a>               
                </div>  
            </div>       

        </form>

    </div>
</div>

@endsection