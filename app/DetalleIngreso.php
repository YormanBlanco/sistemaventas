<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table = 'detalle_ingreso';

    protected $primaryKey = 'id';

    public $timestamps = false; //Para q no me cree los campos por defecto de timestamps

    protected $fillable = [
        'id',
        'idIngreso',
        'idArticulo',
        'cantidad',
        'precio_compra',
        'precio_venta'
    ];

    protected $guarded =[
        
    ];
}
