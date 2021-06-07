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
        $offers=machines_offers::where('Accpted',0)->get();
        return view('machines/offers/offers',compact('offers'));
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
    public function edit(Request $request) 
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\machines_offers  $machines_offers
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, machines_offers $machines_offers)
    {
        //
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
}
