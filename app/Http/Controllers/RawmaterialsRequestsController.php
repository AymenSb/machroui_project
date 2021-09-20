<?php

namespace App\Http\Controllers;

use App\Models\rawmaterials_requests;
use App\Models\rawMaterials;
use App\Models\ClientNotifications;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;


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
        $requestMat=rawmaterials_requests::findOrfail($request->request_id);
        $RawMaterial=rawMaterials::where('id',$requestMat->rawmaterial_id)->first();
        $RawMaterialName= $RawMaterial->name;
        if($request->available){
            $requestMat->update([
                "available"=>1,
                "unavailable"=>0,
                "message"=>"Votre demande est disponible merci de nous contacter"
            ]);
            ClientNotifications::create([
                "title"=>"Matière première disponible",
                "subtitle"=>"la matière première $RawMaterialName est disponible",
                "image"=>"data:image/jpeg;base64,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",
                "link"=>"/account/requested-materials",
                "client_id"=>$requestMat->client_id
            ]);
            
        }

        if($request->unavailable){
            $requestMat->update([
                "unavailable"=>1,
                "available"=>0,
                "message"=>"Votre demande est pas encore disponible, nous vous informerons lorsqu'il sera disponible"
            ]);
            ClientNotifications::create([
                "title"=>"Matière première non disponible",
                "subtitle"=>"la matière première $RawMaterialName n'est pas disponible",
                "image"=>"https://thumbs.dreamstime.com/b/not-available-stamp-seal-watermark-distress-style-designed-rectangle-circles-stars-black-vector-rubber-print-title-138796185.jpg",
                "link"=>"/account/requested-materials",
                "client_id"=>$requestMat->client_id
            ]);
        }

        return back();
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

    function demandeRawMaterials(Request $request){
        $id=$request->id;
        rawmaterials_requests::create([
            'client_name'=>$request->client_name,
            'client_surname'=>$request->client_surname,
            'client_email'=>$request->client_email,
            'client_number'=>$request->client_number,
            'client_id'=>$request->client_id,
            'quantity'=>$request->quantity,
            'rawmaterial_id'=>$request->rawmaterial_id
        ]);
        
        return response()->json(
        [
            'message'=>'Votre demande a été envoyée'
        ]
        );
    }

    function ClientMaterials($client_id){
        $materials=DB::table('rawmaterials_requests')
                    ->join('raw_materials','raw_materials.id','rawmaterials_requests.rawmaterial_id')
                    ->select('rawmaterials_requests.*','raw_materials.*')
                    ->where('client_id',$client_id)
                    ->get();
        return response()->json($materials);
    }
}
