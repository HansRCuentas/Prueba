<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Console\Input\Input;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //listar    
        $lista_productos=DB::select("select * from productos");
        return response()->json($lista_productos,200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Guardar
        $nombre=$request->nombre;
        $cantidad=$request->cantidad;
        $precio=$request->precio;
        $detalle=$request->detalle;
        
       $respuesta=DB::insert("insert into productos (nombre,cantidad,precio,detalle) values ('$nombre',$cantidad,$precio,'$detalle')");
        return response()->json(["mensaje"=>"Producto Registrado"],200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //Buscar
        $producto=DB::select("Select * from productos where id=$id limit 1");
        return response()->json($producto,200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //actualizar
        $nombre=$request->nombre;
        $cantidad=$request->cantidad;
        $precio=$request->precio;
        $detalle=$request->detalle;
        
       $respuesta=DB::update("update productos set nombre='$nombre', cantidad=$cantidad,precio=$precio,detalle='$detalle' where id=$id");
        return response()->json(["mensaje"=>"Producto Modificado"],200);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //eliminar
        DB::delete("delete from productos where id=$id");
        return response()->json(["mensaje"=>"Producto Eliminado"],200);
    }
    public function cargarImagen(Request $request,$id)
    {   
        $nombre_imagen='';
        if($file=$request->file("imagen")){
            $nombre_imagen=$file->getClientOriginalName();
            $file->move("imagenes", $nombre_imagen);
            $nombre_imagen="/imagenes/$nombre_imagen";
        }
        $respuesta = DB::update("update productos set imagen='$nombre_imagen' where id=$id");
        return response()->json(["mensaje"=>"Imagen Actualizada"],200);
    }
}
