@extends('layouts.admin')

@section('contenido')

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <h3>Editar proveedor: {{$per->nombre}}</h3>

        @if(count($errors))
            <div class="alert alert-danger" role="alert">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{$error}}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{url ('/compras/proveedor/'.$id.'')}}" method="post">
            {{csrf_field()}} <!-- Llave de seguridad -->
            {{method_field('PATCH')}}
            
            <!-- nombre -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" placeholder="Nombre" required value="{{$per->nombre}}" class="form-control">
                </div>
            </div>

            <!-- Tipo de doucmento -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3">
                    <div class="form-group">
                        <label for="tipo_documento" class="form-label">Tipo</label>
                        <select name="tipo_documento" class="form-control">
                            @if($per->tipo_documento == 'DNI')
                                <option value="DNI" selected>DNI</option>
                                <option value="RIF" selected>RIF</option>
                                <option value="Pasaporte">Pasaporte</option>
                                @elseif($per->tipo_documento == 'RIF')
                                    <option value="DNI">DNI</option>
                                    <option value="RIF" selected>RIF</option>
                                    <option value="Pasaporte">Pasaporte</option>                                   
                                @else
                                    <option value="DNI">DNI</option> 
                                    <option value="RIF">RIF</option>
                                    <option value="Pasaporte" selected>Pasaporte</option>
                            @endif
                        </select>
                    </div>
                </div>
                <!-- num_documento -->
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-7">
                    <div class="form-group">
                        <label for="num_documento" class="form-label">Num. Documento</label>
                        <input type="text" name="num_documento" placeholder="Ejemplo: V-XXXXXXXX o E-XXXXXXXXXX" required value="{{$per->num_documento}}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- email -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="form-group">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" placeholder="Ejemplo: ejemplo@ejemplo.com" value="{{$per->email}}" class="form-control">
                </div>
            </div>

            <!-- num de telefono -->
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <div class="col-lg-10 col-md-10 col-sm-10 col-xs-10">
                    <div class="form-group">
                        <label for="telefono" class="form-label">Num. Telefono</label>
                        <input type="text" name="telefono" placeholder="Ejemplo: 555555" value="{{$per->telefono}}" class="form-control">
                    </div>
                </div>
            </div>

            <!-- direccion -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="form-group">
                    <label for="direccion" class="form-label">Direccion</label>
                    <input type="text" name="direccion" placeholder="Direccion" value="{{$per->direccion}}" class="form-control">
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