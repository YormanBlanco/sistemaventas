@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3>Nuevo Proveedor</h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url('compras/proveedor')}}" method="POST">
            {{csrf_field()}} <!-- Llave de seguridad -->
            
            <!-- nombre -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" required value="{{old('nombre')}}" class="form-control">
                </div>
            </div>

            <!-- Tipo de doucmento -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="tipo_documento" class="form-label">Tipo</label>
                        <select name="tipo_documento" class="form-control">
                                <option value="DNI">DNI</option>
                                <option value="RIF">RIF</option>
                                <option value="Pasaporte">Pasaporte</option>
                        </select>
                    </div>
                </div>
                <!-- num_documento -->
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="form-group">
                        <label for="num_documento" class="form-label">Num. Documento</label>
                        <input type="text" name="num_documento" placeholder="Ejemplo: V-XX..., E-XX... o J-XX..." required value="{{old('num_documento')}}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- email -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" placeholder="Ejemplo: ejemplo@ejemplo.com" class="form-control">
                </div>
            </div>

            <!-- Telefono -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <!-- Cod Telefono -->
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="cod_telefono" class="form-label">Codigo</label>
                        <select name="cod_telefono" class="form-control">
                                <option value="0244">0244</option>
                                <option value="0416">0416</option>
                                <option value="0426">0426</option>
                                <option value="0414">0414</option>
                                <option value="0424">0424</option>
                                <option value="0412">0412</option>
                        </select>
                    </div>
                </div>
                <!-- num de telefono -->
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="form-group">
                        <label for="telefono" class="form-label">Num. Telefono</label>
                        <input type="text" name="telefono" placeholder="Ejemplo: 555555" class="form-control">
                    </div>
                </div>
            </div>

            <!-- direccion -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" name="direccion" placeholder="Direccion" class="form-control">
                </div>
            </div>


            <!-- Botones -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <button class="btn btn-primary" type="submit">Guardar</button>                                
                    <a href="{{url('compras/proveedor')}}" class="btn btn-danger">Cancelar</a>  
                </div>   
            </div>      

        </form>

    </div>
</div>

@endsection