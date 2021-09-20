<?php

namespace App\Http\Controllers;

use App\Models\MachinesAttachments;
use App\Models\machines;
use App\Models\ClientNotifications;
use App\Models\RequestedMachines;
use Illuminate\Http\Request;

class RequestedMachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requested=RequestedMachines::all();
        return view('machines/requestedMachines/index',compact('requested'));
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
     * @param  \App\Models\RequestedMachines  $requestedMachines
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            
        $machine=RequestedMachines::findOrFail($id);
        
        
       if($machine==null){
        return redirect('/machines');
        }
        return view('machines/requestedMachines/show',compact('machine'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RequestedMachines  $requestedMachines
     * @return \Illuminate\Http\Response
     */
    public function edit(RequestedMachines $requestedMachines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\RequestedMachines  $requestedMachines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RequestedMachines $requestedMachines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RequestedMachines  $requestedMachines
     * @return \Illuminate\Http\Response
     */
    public function destroy(RequestedMachines $requestedMachines)
    {
        //
    }

    public function accept($id){
        $requestedMachine=RequestedMachines::findOrfail($id);
        $name=$requestedMachine->name;
        $price=$requestedMachine->price;
        $Vendor=$requestedMachine->Vendor;
        $vendor_id=$requestedMachine->vendor_id;
        $main_image=$requestedMachine->main_image;
        $images=$requestedMachine->images;
        $base64Urls=$requestedMachine->base64Urls;
        $details=$requestedMachine->details;
        $characteristics=$requestedMachine->characteristics;
        $markDetails=$requestedMachine->markDetails;
        $state=$requestedMachine->state;
        $stateVal=$requestedMachine->stateVal;
        $video_name=$requestedMachine->video_name;
        $video_base64=$requestedMachine->video_base64;

        $machine=new machines();
        $machine->name=$name;
        $machine->price=$price;
        $machine->Vendor=$Vendor;
        $machine->vendor_id=$vendor_id;
        $machine->main_image=$main_image;
        $machine->images=$images;
        $machine->base64Urls=$base64Urls;
        $machine->details=$details;
        $machine->characteristics=$characteristics;
        $machine->markDetails=$markDetails;
        $machine->state=$state;
        $machine->stateVal=$stateVal;
        $machine->video_name=$requestedMachine->video_name;
        $machine->video_base64=$requestedMachine->video_base64;
        $machine->save();

        ClientNotifications::create([
            'title'=>'Votre machine a été acceptée',
            'subtitle'=>'Nous avons accepté votre machine "'.$name.'".',
            'image'=>'test',
            'link'=>'/account/sellings',
            'client_id'=>$vendor_id,
        ]);
        

        
        $requestedMachine->delete();
        return redirect(route('machinesrequests.index'));

    }

    public function delete($id){
        $requestedMachine=RequestedMachines::findOrfail($id);
      
        $requestedMachine->delete();
        return redirect(route('machinesrequests.index'));

    }
}
