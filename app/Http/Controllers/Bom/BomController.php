<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bom;

class BomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bom = new Bom();
        return $bom->select('id', 'productName', 'productQuantity', 'productStatus', 'created_at')->orderBy('created_at', 'desc')->get();
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
        $bom = new Bom();
        $bom->productName = $request->input('product_name');
        $bom->productQuantity = $request->input('product_quantity');
        $bom->productStatus = "Not Approved";
        $bom->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($id){
            return Bom::where('id', $id)->get();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $bom = Bom::find($id);
        $bom->productName = $request->toArray()[0]['productName'];
        $bom->productQuantity = $request->toArray()[0]['productQuantity'];
        $bom->save();
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
