<?php

namespace App\Http\Controllers;

use App\Models\rawmaterials_requests;
use App\Models\rawMaterials;
use Illuminate\Http\Request;

class RawmaterialsRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests=rawmaterials_requests::where('Accpted',0)->get();
        return view('rawmaterials/requests/index',compact('requests'));
    
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rawmaterials_requests  $rawmaterials_requests
     * @return \Illuminate\Http\Response
     */
    public function show(rawmaterials_requests $rawmaterials_requests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rawmaterials_requests  $rawmaterials_requests
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id =$request->request_id;
        $material_request=rawmaterials_requests::findOrfail($id);
        $material_request->update([
            'Accpted'=>1
        ]);

        $material=rawMaterials::findOrfail($material_request->rawmaterial_id);
        $material->update([
            'requests'=>$material->requests+1,
        ]);
        session()->flash('Add', 'Requête acceptée');
        return redirect('rawmaterials-requests');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rawmaterials_requests  $rawmaterials_requests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rawmaterials_requests $rawmaterials_requests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rawmaterials_requests  $rawmaterials_requests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $request=rawmaterials_requests::findOrfail($request->request_id);
        $material_id=$request->rawmaterial_id;
        $accepted=$request->Accpted;
        if($accepted==1){
            $material=rawMaterials::findOrfail($request->rawmaterial_id);
            $material->update([
                'requests'=>$material->requests -1,
            ]);

            $request->delete();
            
           session()->flash('edit', 'Requête supprimer');
           return redirect('rawmaterials/'.$material_id);
        }

        $request->delete();

        session()->flash('edit', 'Requête supprimer');
        return redirect('rawmaterials-requests');
    }
}
