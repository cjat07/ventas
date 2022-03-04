<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Productos;
use App\Models\Ventas;
use App\Models\VentaProducto;

class VentasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ventas::all();
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
        $productos= $request->productos;
        $subtotal= $this->totales($productos)['Subtotal'];
        $total= $this->totales($productos)['Total'];     
        $iva = $this->totales($productos)['Iva']; 

        $venta = new Ventas;
        $venta->numero_factura= uniqid();
        $venta->cliente= $request->cliente;
        $venta->telefono= $request->telefono;
        $venta->correo= $request->correo;
        $venta->subtotal= $subtotal;
        $venta->iva=$iva;
        $venta->total= $total;
        $venta->save();

        $generar= $this->ventasproductos($productos,$venta->id);

        if ($generar) {
            return ['mensaje'=>'Venta generada'];
        }


        return ['mensaje'=>'Error al generar la venta'];
    }

    public function totales($productos){
        $subtotal = 0;
        $total = 0;
        $iva = 0;
        foreach ($productos as $producto) {
            $search= Productos::find($producto['id']);
            $subtotal+=($search->precio * $producto['cantidad']);
            $total+=(($search->precio + $search['iva']) * $producto['cantidad']);
            $iva+= ($search->iva * $producto['cantidad']);
            $search->cantidad = ($search->cantidad - $producto['cantidad']);
            $search->save();
        }
        return ['Subtotal'=>$subtotal,'Total'=>$total,'Iva'=>$iva];
    }

    public function ventasproductos($productos,$id){ 
        try {
            foreach ($productos as $producto) {
                $search= Productos::find($producto['id']);
    
                $productovendido= new VentaProducto;
                $productovendido->producto_id= $producto['id'];
                $productovendido->venta_id= $id;
                $productovendido->cantidad= $producto['cantidad'];
                $productovendido->valor=($search->precio * $producto['cantidad']);
                $productovendido->iva= ($search->iva * $producto['cantidad']);
                $productovendido->valor_total= (($search->precio + $search['iva']) * $producto['cantidad']);
                $productovendido->save();
    
            }
            return true;
        } catch (\Throwable $th) {
            return false;
        }      

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
