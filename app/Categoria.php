<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'categoria';

    protected $primaryKey = 'id';

    public $timestamps = false; //Para q no me cree los campos por defecto de timestamps

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'estado'
    ];

    protected $guarded =[
        
    ];
}
