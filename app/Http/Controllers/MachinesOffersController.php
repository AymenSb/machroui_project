<?php

namespace App\Http\Controllers;

use App\Models\machines_offers;
use App\Models\machines;

use Illuminate\Http\Request;


class MachinesOffersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
      return back();
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
     * @param  \App\Models\machines_offers  $machines_offers
     * @return \Illuminate\Http\Response
     */
    public function show(machines_offers $machines_offers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\machines_offers  $machines_offers
     * @return \Illuminate\Http\Response
     */
    public function edit($id) 
    {   
        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\machines_offers  $machines_offers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id =$request->request_id;
        $machine_offer=machines_offers::findOrfail($id);
        $machine_offer->update([
            'Accpted'=>1
        ]);

        $machine=machines::findOrfail($machine_offer->machine_id);
        $machine->update([
            'offers'=>$machine->offers+1,
        ]);
        session()->flash('Add', 'Demande acceptée');
        return redirect('machines-offers');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\machines_offers  $machines_offers
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $offer=machines_offers::findOrfail($request->request_id);
        $machine_id=$offer->machine_id;
        $accepted=$offer->Accpted;
        if($accepted==1){
            $machine=machines::findOrfail($offer->machine_id);
            $machine->update([
                'offers'=>$machine->offers -1,
            ]);

           $offer->delete();
           session()->flash('edit', 'Offre supprimer');
           return redirect('machines/'.$machine_id);
        }

        $offer->delete();

        session()->flash('edit', 'Offre supprimer');
        return redirect('machines-offers');
    }

    public function machinesOffers(Request $request){
        machines_offers::create([
            "client_name"=>$request->client_name,
            "client_surname"=>$request->client_surname,
            "client_email"=>$request->client_email,
            "client_number"=>$request->client_number,
            "client_offer"=>$request->client_offer,
            "machine_id"=>$request->machine_id,
        ]);
        return response()->json([
            'message'=>'Votre demande à été envoyé.'
        ]);

    }
    public function sendToVendor(Request $request){
        $offer=machines_offers::where('id',$request->request_id)->first();
        $offer->update([
            'Accpted'=>1,
        ]);
        
        return back();
    }

    public function vendorOffers($id){
        $offers=machines_offers::where('machine_id',$id)
                                ->where('Accpted',1)
                                ->get();
        return $offers;
    }
    public function acceptOffer(Request $request){
        $offer=machines_offers::where('id',$request->offer_id)->first();
        $machine_id=$offer->machine_id;
        $machine=machines::where('id',$machine_id)->first();
        if($offer->hasAcceptedOffer==0){
            $offer->update([
                'hasAcceptedOffer'=>1
             ]);
            $machine->update([
                'offers'=>$machine->offers-1
            ]);
        }
         
         return response()->json([
            "message"=>"Vous avez accepté l'offre, nous vous contacterons bientôt."
         ]);
    }
    public function RefuseOffer(Request $request){
        $offer=machines_offers::where('id',$request->offer_id)->first();
        $offer->update([
            'hasRefusedOffer'=>1
        ]);

        return response()->json([
            "message"=>"Vous avez réfuser cette offre."
         ]);
    }
}
