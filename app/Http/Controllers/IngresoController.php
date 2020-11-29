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

use App\Ingreso;
use App\DetalleIngreso;
use App\Http\Requests\IngresoFormRequest;


class IngresoController extends Controller
{
    public function __construct() //Constructor
    {

    }

    public function index(Request $request) //Index
    {      

        if($request->get('searchText')){ //Si hay una busqueda

            $query = trim($request->get('searchText')); //Obtengo lo escrito en el campo searchText
            
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p', 'i.idProveedor','=','p.id')
                ->join('detalle_ingreso as di', 'i.id','=','di.idIngreso')
                ->select('i.id','i.fecha_hora','p.nombre','i.tipo_comprobante', 'i.serie_comprobante',
                            'i.num_comprobante','i.impuesto','i.estado',
                        DB::raw('sum(di.cantidad*precio_compra) as total'))
                ->where('i.num_comprobante','LIKE','%'.$query.'%')
                ->orwhere('p.nombre','LIKE','%'.$query.'%')
                ->orwhere('i.serie_comprobante','LIKE','%'.$query.'%')
                ->orwhere('i.tipo_comprobante','LIKE','%'.$query.'%')
                ->orderBy('i.fecha_hora','desc')
                ->groupBy('i.id','i.fecha_hora','p.nombre','i.tipo_comprobante', 'i.serie_comprobante',
                            'i.num_comprobante','i.impuesto','i.estado')
                ->paginate(7);

            return view(
                'compras.ingreso.index', 
                [
                    'ingresos'=>$ingresos,
                    'searchText'=>$query
                ]
            );

        }
        else{ //si no hay una busqueda
            $ingresos = DB::table('ingreso as i')
                ->join('persona as p', 'i.idProveedor','=','p.id')
                ->join('detalle_ingreso as di', 'i.id','=','di.idIngreso')
                ->select('i.id','i.fecha_hora','p.nombre','i.tipo_comprobante', 'i.serie_comprobante',
                            'i.num_comprobante','i.impuesto','i.estado',
                        DB::raw('sum(di.cantidad*precio_compra) as total'))
                ->orderBy('i.fecha_hora','desc')
                ->groupBy('i.id','i.fecha_hora','p.nombre','i.tipo_comprobante', 'i.serie_comprobante',
                            'i.num_comprobante','i.impuesto','i.estado')
                ->paginate(7);

            return view(
                'compras.ingreso.index', 
                [
                    'ingresos'=>$ingresos
                ]
            );
        }

    }

    public function create()
    {
        $personas = DB::table('persona')->where('tipo_persona','Proveedor')->get();

        $articulos = DB::table('articulo as art')
            ->select(DB::raw('CONCAT(art.codigo," ",art.nombre) as articulo'), 'art.id')
            ->where('art.estado','Activo')->get();

        return view(
            'compras.ingreso.create',
            [
                'personas'=>$personas,
                'articulos'=>$articulos
            ]
        );
    }

    public function store(IngresoFormRequest $request)
    {

        try{

            DB::beginTransaction();

            $ingreso = new Ingreso;
            $ingreso->id = (string) Str::uuid(); //Genera un uuid v4
            $ingreso->idProveedor = $request->get('idProveedor');
            $ingreso->tipo_comprobante = $request->get('tipo_comprobante');
            $ingreso->serie_comprobante = $request->get('serie_comprobante');
            $ingreso->num_comprobante = $request->get('num_comprobante');
            $mytime = Carbon::now('America/Caracas');
            $ingreso->fecha_hora = $mytime->toDateTimeString();
            $ingreso->impuesto = '16';
            $ingreso->estado = 'A';
            $ingreso->save(); //Guardo en el modelo

            $idArticulo = $request->get('idArticulo');
            $cantidad = $request->get('cantidad');
            $precio_compra = $request->get('precio_compra');
            $precio_venta = $request->get('precio_venta');

            $cont = 0;
            while($cont < count($idArticulo)){ //Mientras cont sea menor q la cantidad de articulos

                $detalle = new DetalleIngreso;
                $detalle->id = (string) Str::uuid(); //Genera un uuid v4

                $ingresoID = DB::table('ingreso') //Obtengo el id del ingreso para pasarlo al detalleIngreso
                    ->select('id')
                    ->where('fecha_hora',$mytime)
                    ->first();  //firstt() en vez de get() para q me traiga un solo objeto y no la coleccion de objetos        
                $detalle->idIngreso = $ingresoID->id;

                $detalle->idArticulo = $idArticulo[$cont];              
                $detalle->cantidad = $cantidad[$cont];
                $detalle->precio_compra = $precio_compra[$cont];
                $detalle->precio_venta = $precio_venta[$cont];
                $detalle->save(); //Guardo el modelo

                $cont++;
            }

            DB::commit();

        }
        catch(Exception $e){
            DB::rollback();
        } 

        return redirect('compras/ingreso'); 

    }

    public function show($id)
    {
        $ingreso = DB::table('ingreso as i')
                ->join('persona as p', 'i.idProveedor','=','p.id')
                ->join('detalle_ingreso as di', 'i.id','=','di.idIngreso')
                ->select('i.id','i.fecha_hora','p.nombre','i.tipo_comprobante', 'i.serie_comprobante',
                    'i.num_comprobante','i.impuesto','i.estado',
                    DB::raw('sum(di.cantidad*precio_compra) as total'))
                ->where('i.id',$id)
                ->groupBy('i.id', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante',
                    'i.num_comprobante', 'i.impuesto', 'i.estado')
                ->first();

        $detalles = DB::table('detalle_ingreso as d')
                ->join('articulo as a', 'd.idArticulo', '=', 'a.id')
                ->select('a.nombre as articulo', 'd.cantidad', 'd.precio_compra', 'd.precio_venta')
                ->where('d.idIngreso', $id)
                ->get();
                    

        return view('compras.ingreso.show', 
            [
                'ingreso'=>$ingreso,
                'detalles'=>$detalles
            ]
        );
    } 

    public function destroy($id)
    {
        $ingreso=Ingreso::findOrFail($id);
        $ingreso->estado = 'Inactivo'; //El estado pasa a ser Inactivo
        $ingreso->update();

        return redirect('compras/ingreso');
    }
}
