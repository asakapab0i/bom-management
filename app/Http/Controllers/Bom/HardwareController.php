<?php

namespace App\Http\Controllers\Bom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Hardware;

class HardwareController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $har = new Hardware();
        return $har->select('id', 'hardwareName', 'hardwareQuantity', 'created_at')->orderBy('created_at', 'desc')->get();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $har = new Hardware();
        $har->hardwareName= $request->input('hardware_name');
        $har->hardwareQuantity= $request->input('hardware_quantity');
        $har->save();
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
            return Hardware::where('id', $id)->get();
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
        $har = Hardware::find($id);
        $har->hardwareName = $request->toArray()[0]['hardwareName'];
        $har->hardwareQuantity= $request->toArray()[0]['hardwareQuantity'];
        $har->save();
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

    public function hardware_categories(){
        $mat = new Hardware();
        $matResult = $mat->select('id', 'hardwareName', 'hardwareQuantity')->orderBy('created_at', 'desc')->get();
        $matArr = [];
        foreach($matResult as $k => $v){
            $matArr['value'] = $v->hardwareName;
            $matArr['text'] = $v->hardwareName;

            $matArr2[] = $matArr;
        }

        return $matArr2;
    }
}
