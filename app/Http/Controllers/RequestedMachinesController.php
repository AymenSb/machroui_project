<?php

namespace App\Http\Controllers;

use App\Models\MachinesAttachments;
use App\Models\machines;
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
        $details=$requestedMachine->details;
        $characteristics=$requestedMachine->characteristics;
        $markDetails=$requestedMachine->markDetails;
        $state=$requestedMachine->state;
        $stateVal=$requestedMachine->stateVal;

        $machine=new machines();
        $machine->name=$name;
        $machine->price=$price;
        $machine->Vendor=$Vendor;
        $machine->details=$details;
        $machine->characteristics=$characteristics;
        $machine->markDetails=$markDetails;
        $machine->state=$state;
        $machine->stateVal=$stateVal;
        $machine->save();

        $requestedMachine->delete();
        return redirect(route('machinesrequests.index'));

    }

    public function delete($id){
        $requestedMachine=RequestedMachines::findOrfail($id);
        $name=$requestedMachine->name;
        $price=$requestedMachine->price;
        $Vendor=$requestedMachine->Vendor;
        $details=$requestedMachine->details;
        $characteristics=$requestedMachine->characteristics;
        $markDetails=$requestedMachine->markDetails;
        $state=$requestedMachine->state;
        $stateVal=$requestedMachine->stateVal;
        $requestedMachine->delete();
        return redirect(route('machinesrequests.index'));

    }
}
