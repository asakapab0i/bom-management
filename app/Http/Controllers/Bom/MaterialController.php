<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Material;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mat = new Material();
        return $mat->select('id', 'materialName', 'materialQuantity', 'created_at')->orderBy('created_at', 'desc')->get();
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
        $mat = new Material();
        $mat->materialName = $request->input('material_name');
        $mat->materialQuantity = $request->input('material_quantity');
        $mat->save();
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
            return Material::where('id', $id)->get();
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
        $mat = Material::find($id);
        $mat->materialName = $request->toArray()[0]['materialName'];
        $mat->materialQuantity = $request->toArray()[0]['materialQuantity'];
        $mat->save();
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

    public function material_categories(){
        $mat = new Material();
        $matResult = $mat->select('id', 'materialName', 'materialQuantity')->orderBy('created_at', 'desc')->get();
        $matArr = [];
        foreach($matResult as $k => $v){
            $matArr['value'] = $v->materialName;
            $matArr['text'] = $v->materialName;

            $matArr2[] = $matArr;
        }

        return $matArr2;
    }
}
