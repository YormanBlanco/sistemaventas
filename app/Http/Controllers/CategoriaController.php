<?php

namespace App\Http\Controllers;

use App\Categoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str; //Para usar Str::uuid
use App\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
{
    public function __construct() //Constructor
    {

    }

    public function index(Request $request) //Index
    {      

        if($request->get('searchText')){ //Si hay una busqueda

            $query = trim($request->get('searchText')); //Obtengo lo escrito en el campo searchText
            
            $categorias = DB::table('categoria')
                ->select(DB::raw('DATE_FORMAT(fecha_registro,"%d-%m-%Y %h:%i:%s") as fecha_registro'), 
                'id','nombre','descripcion')
                ->where('estado','1')
                ->where('nombre', 'LIKE', '%'.$query.'%')
                ->orderBy('nombre','asc')
                ->orderBy('fecha_registro','desc')
                ->paginate(7);

            return view(
                'almacen.categoria.index', 
                [
                    'categorias'=>$categorias,
                    'searchText'=>$query
                ]
            );

        }
        else{ //si no hay una busqueda
                $categorias = DB::table('categoria')
                ->select(DB::raw('DATE_FORMAT(fecha_registro,"%d-%m-%Y %h:%i:%s") as fecha_registro'), 
                'id','nombre','descripcion')
                ->where('estado','1')
                ->orderBy('nombre','asc')
                ->orderBy('fecha_registro','desc')
                ->paginate(7);
                
            return view(
                'almacen.categoria.index', 
                [
                    'categorias'=>$categorias
                ]
            );
        }

    }

    public function create()
    {
        return view('almacen.categoria.create');
    }

    public function store(CategoriaFormRequest $request)
    {
        $categoria = new Categoria;
        $categoria->id = (string) Str::uuid(); //Genera un uuid v4
        $categoria->nombre = $request->get('nombre');
        $categoria->descripcion = $request->get('descripcion');
        $categoria->estado = '1'; //1 si esta activa 0 si esta inactiva (por defecto estara activa)
        $categoria->save(); //Guardo en la DB

        return redirect('almacen/categoria');

    }

    public function show($id)
    {
        return view('almacen.categoria.show', 
            [
                'categoria'=>Categoria::findOrFail($id)
            ]
        );
    } 

    public function edit($id)
    {
        $categoria = Categoria::findOrFail($id); 
        return view(
            'almacen.categoria.edit', 
            [
                'categoria'=>$categoria,
                'id'=>$id
            ]
        ); 

    }

    public function update(CategoriaFormRequest $request, $id)
    {
        $categoria = request()->except('_token','_method'); //Todos los datos except el _token y el _method
        Categoria::where('id','=',$id)->update($categoria);

        return redirect('almacen/categoria');
    }

    public function destroy($id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->estado = '0'; //La condcion pasa a ser 0 = inactiva
        $categoria->update();

        return redirect('almacen/categoria');
    }
}
