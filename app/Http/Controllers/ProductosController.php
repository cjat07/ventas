<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Productos::all();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $search = Productos::where('sku',$request->sku)->first();

        if ($search) {
            return 'Producto ya existe';
        }
        $nuevo = new Productos;
        $nuevo->sku = $request->sku;
        $nuevo->nombre = $request->nombre;
        $nuevo->descripcion = $request->descripcion;
        $nuevo->cantidad = $request->cantidad;
        $nuevo->foto = $request->foto;
        $nuevo->precio = $request->precio;
        $nuevo->iva = $request->iva;
        $nuevo->save();

        return ['mensaje'=>'Se ha guardo el producto'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $search = Productos::find($id);

        if ($search=="") {
            return ['mensaje'=>'Producto no existe'];
        }

        return $search;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $search = Productos::find($id);
        if ($search=="") {
            return ['mensaje'=>'Producto no existe'];
        }
        $search->sku = $request->sku;
        $search->nombre = $request->nombre;
        $search->descripcion = $request->descripcion;
        $search->cantidad = $request->cantidad;
        $search->foto = $request->foto;
        $search->precio = $request->precio;
        $search->iva = $request->iva;
        $search->save(); 
        
        return ['mensaje'=>'Se ha actualizado el producto'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $search= Productos::find($id);
        if ($search=="") {
            return ['mensaje'=>'Producto no existe'];
        }
        $search->delete();

        return ['mensaje'=>'Se ha eliminado el producto'];

    }
}
