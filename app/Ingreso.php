<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'ingreso';

    protected $primaryKey = 'id';

    public $timestamps = false; //Para q no me cree los campos por defecto de timestamps

    protected $fillable = [
        'id',
        'idProveedor',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'estado'
    ];

    protected $guarded =[
        
    ];
}
