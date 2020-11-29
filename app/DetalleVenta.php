<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = 'detalle_venta';

    protected $primaryKey = 'id';

    public $timestamps = false; //Para q no me cree los campos por defecto de timestamps

    protected $fillable = [
        'id',
        'idArticulo',
        'idVenta',
        'cantidad',
        'precio_venta',
        'descuento'
    ];

    protected $guarded =[
        
    ];
}
