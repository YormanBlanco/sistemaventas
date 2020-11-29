<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    //
    protected $table = 'articulo';
    protected $primaryKey = 'id';
    public $timestamps = false; //Para q no me cree los campos por defecto de timestamps

    protected $fillable = [
        'id',
        'idCategoria',
        'codigo',
        'nombre',
        'stock',
        'descripcion',
        'imagen',
        'estado'
    ];

    protected $guarded =[
        
    ];


}
