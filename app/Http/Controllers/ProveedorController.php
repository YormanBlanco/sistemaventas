<?php

namespace App\Http\Controllers;
use App\Persona;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; //Para usar Str::uuid
use App\Http\Requests\PersonaFormRequest;
use DB;

class ProveedorController extends Controller
{
    public function __construct() //Constructor
    {

    }

    public function index(Request $request) //Index
    {      

        if($request->get('searchText')){ //Si hay una busqueda

            $query = trim($request->get('searchText')); //Obtengo lo escrito en el campo searchText
            
            $personas = DB::table('persona')
                ->select(DB::raw('DATE_FORMAT(fecha_registro,"%d-%m-%Y %h:%i:%s") as fecha_registro'), 
                'id','nombre', 'tipo_documento', 'num_documento', 'telefono', 'email')
                ->where('tipo_persona','proveedor')
                ->where('nombre', 'LIKE', '%'.$query.'%')
                ->orwhere('num_documento', 'LIKE', '%'.$query.'%')
                ->where('tipo_persona','proveedor')               
                ->orderBy('nombre','asc')
                ->orderBy('fecha_registro','desc')
                ->paginate(7);

            return view(
                'compras.proveedor.index', 
                [
                    'personas'=>$personas,
                    'searchText'=>$query
                ]
            );

        }
        else{ //si no hay una busqueda
                $personas = DB::table('persona')
                ->select(DB::raw('DATE_FORMAT(fecha_registro,"%d-%m-%Y %h:%i:%s") as fecha_registro'), 
                'id','nombre', 'tipo_documento', 'num_documento', 'telefono', 'email')
                ->where('tipo_persona','proveedor')                   
                ->orderBy('nombre','asc')
                ->orderBy('fecha_registro','desc')
                ->paginate(7);
                
            return view(
                'compras.proveedor.index', 
                [
                    'personas'=>$personas
                ]
            );
        }

    }

    public function create()
    {
        return view('compras.proveedor.create');
    }

    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona;
        $persona->id = (string) Str::uuid(); //Genera un uuid v4
        $persona->tipo_persona = 'proveedor'; 
        $persona->nombre = $request->get('nombre');
        $persona->tipo_documento = $request->get('tipo_documento');
        $persona->num_documento = $request->get('num_documento');
        $persona->direccion = $request->get('direccion');
        $persona->telefono = $request->get('cod_telefono') . '-' . $request->get('telefono');
        $persona->email = $request->get('email');

        $persona->save(); //Guardo en la DB
        return redirect('compras/proveedor');

    }

    public function show($id)
    {
        return view('compras.proveedor.show', 
            [
                'persona'=>Persona::findOrFail($id)
            ]
        );
    } 

    public function edit($id)
    {
        $persona = Persona::findOrFail($id); 
        return view(
            'compras.proveedor.edit', 
            [
                'per'=>$persona,
                'id'=>$id
            ]
        ); 

    }

    public function update(PersonaFormRequest $request, $id)
    {
        $persona = request()->except('_token','_method'); //Todos los datos except el _token y el _method
        Persona::where('id','=',$id)->update($persona);

        return redirect('compras/proveedor');
    }

    public function destroy($id)
    {
        $persona=Persona::findOrFail($id);
        $persona->tipo_persona = 'Inactivo'; //El tipo_persona pasa a ser Inactivo
        $persona->update();

        return redirect('compras/proveedor');
    }
}
