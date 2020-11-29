<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str; //Para usar Str::uuid
use Illuminate\Support\Collection;
use Carbon\Carbon; //Para hacer uso de nuestra zona horaria
use DB;
use Response;

use App\Venta;
use App\DetalleVenta;
use App\Http\Requests\VentaFormRequest;

class VentaController extends Controller
{
    public function __construct() //Constructor
    {

    }

    public function index(Request $request) //Index
    {      

        if($request->get('searchText')){ //Si hay una busqueda

            $query = trim($request->get('searchText')); //Obtengo lo escrito en el campo searchText
            
            $ventas = DB::table('venta as v')
                ->join('persona as p', 'v.idCliente','=','p.id')
                ->join('detalle_venta as dv', 'v.id','=','dv.idVenta')
                ->select('v.id','v.fecha_hora','p.nombre','v.tipo_comprobante', 'v.serie_comprobante',
                            'v.num_comprobante','v.impuesto', 'v.total_venta', 'v.estado')
                ->where('v.num_comprobante','LIKE','%'.$query.'%')
                ->orwhere('p.nombre','LIKE','%'.$query.'%')
                ->orwhere('v.serie_comprobante','LIKE','%'.$query.'%')
                ->orwhere('v.tipo_comprobante','LIKE','%'.$query.'%')
                ->orderBy('v.fecha_hora','desc')
                ->groupBy('v.id','v.fecha_hora','p.nombre','v.tipo_comprobante', 'v.serie_comprobante',
                            'v.num_comprobante','v.impuesto', 'v.total_venta', 'v.estado')
                ->paginate(7);

            return view(
                'ventas.venta.index', 
                [
                    'ventas'=>$ventas,
                    'searchText'=>$query
                ]
            );

        }
        else{ //si no hay una busqueda
            $ventas = DB::table('venta as v')
                ->join('persona as p', 'v.idCliente','=','p.id')
                ->join('detalle_venta as dv', 'v.id','=','dv.idVenta')
                ->select('v.id','v.fecha_hora','p.nombre','v.tipo_comprobante', 'v.serie_comprobante',
                            'v.num_comprobante','v.impuesto', 'v.total_venta', 'v.estado')
                ->groupBy('v.id','v.fecha_hora','p.nombre','v.tipo_comprobante', 'v.serie_comprobante',
                            'v.num_comprobante','v.impuesto', 'v.total_venta', 'v.estado')
                ->orderBy('v.fecha_hora','desc')
                ->paginate(7);

            return view(
                'ventas.venta.index', 
                [
                    'ventas'=>$ventas
                ]
            );
        }

    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona','Cliente')->get();

        /*
        Consulta mysql q quiero:
            SELECT CONCAT(art.codigo,' ',art.nombre) as articulo, art.id, art.stock,
            SUBSTRING_INDEX(GROUP_CONCAT(di.precio_venta ORDER BY ing.fecha_hora DESC), ',', 1 ) AS ultimo_precio
            FROM articulo as art
            INNER JOIN detalle_ingreso as di ON di.idArticulo = art.id
            INNER JOIN ingreso as ing ON ing.id = di.idIngreso
            WHERE art.stock > 0 AND art.estado = 'Activo'
            GROUP BY articulo, art.id, art.stock
        */

        /* $articulos = DB::table('articulos as art')
            ->join('detalle_ingreso as di', 'art.id','=','di.idArticulo')
            ->join('ingreso as ing', 'ing.id','=','di.idIngreso')
            ->select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'), 'art.id',
                        'art.stock', 
                        DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(di.precio_venta ORDER BY ing.fecha_hora DESC), ',', 1) AS ultimo_precio'))
            ->where('art.stock','>',0)
            ->where('art.estado','Activo')
            ->groupBy('art.id')
            ->get();     */

        $articulos = DB::select(
                        DB::raw(
                            "SELECT CONCAT(art.codigo,' ',art.nombre) as articulo, art.id, art.stock,
                            SUBSTRING_INDEX(GROUP_CONCAT(di.precio_venta ORDER BY ing.fecha_hora DESC), ',', 1) AS ultimo_precio
                            FROM articulo as art
                            INNER JOIN detalle_ingreso as di ON di.idArticulo = art.id
                            INNER JOIN ingreso as ing ON ing.id = di.idIngreso
                            WHERE art.stock > 0 AND art.estado = 'Activo'
                            GROUP BY articulo, art.id, art.stock"
                        )
                    );    

        return view(
            'ventas.venta.create',
            [
                'personas'=>$personas,
                'articulos'=>$articulos
            ]
        );
    }

    
    public function store(VentaFormRequest $request)
    {

        try{

            DB::beginTransaction();

            $venta = new Venta;
            $venta->id = (string) Str::uuid(); //Genera un uuid v4
            $venta->idCliente = $request->get('idCliente');
            $venta->tipo_comprobante = $request->get('tipo_comprobante');
            $venta->serie_comprobante = $request->get('serie_comprobante');
            $venta->num_comprobante = $request->get('num_comprobante');
            $venta->total_venta = $request->get('total_venta');
            $mytime = Carbon::now('America/Caracas');
            $venta->fecha_hora = $mytime->toDateTimeString();
            $venta->impuesto = '16';
            $venta->estado = 'A';
            $venta->save(); //Guardo en el modelo

            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $descuento = $request->get('descuento');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;
            while($cont < count($idArticulo)){ //Mientras cont sea menor q la cantidad de articulos

                $detalle = new DetalleVenta;
                $detalle->id = (string) Str::uuid(); //Genera un uuid v4

                $ventaID = DB::table('venta') //Obtengo el id de la venta para pasarlo al detalleVenta
                    ->select('id')
                    ->where('fecha_hora',$mytime)
                    ->first();  //firstt() en vez de get() para q me traiga un solo objeto y no la coleccion de objetos        
                $detalle->idVenta = $ventaID->id;

                $detalle->idArticulo = $idArticulo[$cont];              
                $detalle->cantidad = $cantidad[$cont];
                $detalle->descuento = $descuento[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save(); //Guardo el modelo

                $cont++;
            }

            DB::commit();

        }
        catch(Exception $e){
            DB::rollback();
        } 

        return redirect('ventas/venta'); 

    }

    public function show($id)
    {
        $venta = DB::table('venta as v')
                ->join('persona as p', 'v.idCliente','=','p.id')
                ->join('detalle_venta as dv', 'v.id','=','dv.idVenta')
                ->select('v.id','v.fecha_hora','p.nombre','v.tipo_comprobante', 'v.serie_comprobante',
                    'v.num_comprobante','v.impuesto','v.estado','v.total_venta')
                ->where('v.id',$id)
                ->groupBy('v.id','v.fecha_hora','p.nombre','v.tipo_comprobante', 'v.serie_comprobante',
                'v.num_comprobante','v.impuesto','v.estado','v.total_venta')
                ->first();

        $detalles = DB::table('detalle_venta as dv')
                ->join('articulo as a', 'dv.idArticulo', '=', 'a.id')
                ->select('a.nombre as articulo', 'dv.cantidad', 'dv.descuento', 'dv.precio_venta')
                ->where('dv.idVenta', $id)
                ->get();
                    

        return view('ventas.venta.show', 
            [
                'venta'=>$venta,
                'detalles'=>$detalles
            ]
        );
    } 


    public function destroy($id)
    {
        $venta=Venta::findOrFail($id);
        $venta->estado = 'C'; //El estado pasa a ser C de cancelada
        $venta->update();

        return redirect('ventas/venta');
    } 
}
