<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Bom;
use App\Material;
use App\Hardware;

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
        return $bom->select('id', 'productName', 'productQuantity', 'productStatus', 'material', 'materialQuantity', 'hardware', 'hardwareQuantity', 'created_at')->orderBy('created_at', 'desc')->get();
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
        $bom->hardware = $request->toArray()[0]['hardware'];
        $bom->material = $request->toArray()[0]['material'];
        $bom->hardwareQuantity = $request->toArray()[0]['hardwareQuantity'];
        $bom->materialQuantity = $request->toArray()[0]['materialQuantity'];
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

    public function approve(Request $request, $id){
        $bom = Bom::find($id)->get();
        $mat = Material::find($bom[0]->material)->get();
        $har = Hardware::find($bom[0]->hardware)->get();
        $materialQuantity = $hardwareQuantity = $bomMatQty = $bomHarQty = 0;

        foreach($bom as $bk => $bv){
            $bomMatQty = $bv->materialQuantity;
            $bomHarQty = $bv->hardwareQuantity;
        }

        foreach($mat as $mk => $mv){
            $materialQuantity = $mv->materialQuantity;
        }
        foreach($har as $hk => $hv){
            $hardwareQuantity = $hv->hardwareQuantity;
        }

        if($hardwareQuantity - $bomHarQty >= 0 && $materialQuantity - $bomMatQty >= 0){
            //update

            $matSave = Material::find($mat[0]->id);
            $harSave = Hardware::find($har[0]->id);
            $bomSave = Bom::find($bom[0]->id);

            $matSave->materialQuantity = $materialQuantity - $bomMatQty;
            $harSave->hardwareQuantity = $hardwareQuantity - $bomHarQty;
            $bomSave->productStatus = "Approved";

            $matSave->save();
            $harSave->save();
            $bomSave->save();
        }else{
            abort(500, 'Something went wrong');
        }

    }
}
