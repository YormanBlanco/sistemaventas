<?php

namespace App\Http\Controllers;

use App\Articulo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input; //Para subir la imagen
use Illuminate\Support\Str; //Para usar Str::uuid
use App\Http\Requests\ArticuloFormRequest;
use DB;

class ArticuloController extends Controller
{
    
    public function __construct() //Constructor
    {

    }

    public function index(Request $request) //Index
    {      

        if($request->get('searchText')){ //Si hay una busqueda

            $query = trim($request->get('searchText')); //Obtengo lo escrito en el campo searchText

            $articulos = DB::table('articulo as a')
                ->join('categoria as c', 'a.idCategoria','=','c.id')
                ->select(DB::raw('DATE_FORMAT(a.fecha_registro,"%d-%m-%Y %h:%i:%s") as fecha_registro'), 
                'a.id','a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')               
                ->where('a.nombre', 'LIKE', '%'.$query.'%')
                ->orwhere('a.id', 'LIKE', '%'.$query.'%')
                ->orwhere('a.codigo', 'LIKE', '%'.$query.'%')
                ->orwhere('c.nombre', 'LIKE', '%'.$query.'%')
                ->orderBy('a.nombre', 'asc') 
                ->orderBy('a.fecha_registro','desc')
                ->paginate(7);

            return view(
                'almacen.articulo.index', 
                [
                    'articulos'=>$articulos,
                    'searchText'=>$query
                ]
            );

        }
        else{ //si no hay una busqueda
            $articulos = DB::table('articulo as a')
                ->join('categoria as c', 'a.idCategoria','=','c.id')
                ->select(DB::raw('DATE_FORMAT(a.fecha_registro,"%d-%m-%Y %h:%i:%s") as fecha_registro'), 
                'a.id','a.nombre', 'a.codigo', 'a.stock', 'c.nombre as categoria', 'a.descripcion', 'a.imagen', 'a.estado')
                ->orderBy('a.nombre', 'asc')            
                ->orderBy('fecha_registro','desc')
                ->paginate(7);

            return view(
                'almacen.articulo.index', 
                [
                    'articulos'=>$articulos          
                ]
            );
        }

    }

    public function create()
    {
        $categorias = DB::table('categoria')
            ->where('estado','1')
            ->orderBy('nombre','asc')
            ->get();
        return view('almacen.articulo.create',['categorias'=>$categorias]);
    }

    public function store(ArticuloFormRequest $request)
    {
        $articulo = new Articulo;
        $articulo->id = (string) Str::uuid(); //Genera un uuid v4
        $articulo->idCategoria = $request->get('idCategoria');
        $articulo->codigo = $request->get('codigo');
        $articulo->nombre = $request->get('nombre');
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');

        if($request->hasFile('imagen') ){ //Si hay una imagen la guardo
            $file = $request->file('imagen');
            $file->move(public_path().'/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        } 

        /*if($request->hasFile('imagen')){ //Si el campo foto es un archivo
            //almaceno la foto obtenida del form en la carpeta storage/app/public/uploads 
            $file=$request->file('imagen')->store('uploads', 'public');
        } */

        $articulo->estado = 'Activo'; //Activo si esta activo, Inactivo si esta inactivo (por defecto estara activo)
        $articulo->save(); //Guardo en la DB

        return redirect('almacen/articulo');

    }

    public function show($id)
    {
        return view('almacen.articulo.show', 
            [
                'articulo'=>articulo::findOrFail($id)
            ]
        );
    } 

    public function edit($id)
    {
        $articulo = Articulo::findOrFail($id); 
        $categorias = DB::table('categoria')->where('estado','1')->get();
        return view(
            'almacen.articulo.edit', 
            [              
                'id'=>$id,
                'articulo'=>$articulo,
                'categorias'=>$categorias
            ]
        ); 

    }

    public function update(ArticuloFormRequest $request, $id)
    {

        $articulo = Articulo::findOrFail($id);
        $articulo->idCategoria = $request->get('idCategoria');
        $articulo->codigo = $request->get('codigo');
        $articulo->nombre = $request->get('nombre');
        $articulo->stock = $request->get('stock');
        $articulo->descripcion = $request->get('descripcion');

        if($request->hasFile('imagen') ){ //Si hay una imagen la guardo
            $file = $request->file('imagen');
            $file->move(public_path().'/imagenes/articulos/', $file->getClientOriginalName());
            $articulo->imagen = $file->getClientOriginalName();
        }

        $articulo->update(); //Actualizo en la DB

        return redirect('almacen/articulo');
    }

    public function destroy($id)
    {
        $articulo=Articulo::findOrFail($id);
        $articulo->estado = 'Inactivo'; //La condcion pasa a ser inactiva
        $articulo->update(); //actualizo en la DB

        return redirect('almacen/articulo');
    }

}
