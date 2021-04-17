<?php

namespace App\Http\Controllers;

use App\Models\MachinesAttachments;
use App\Models\machines;
use Illuminate\Http\Request;

class MachinesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        if ($request->hasFile('file_name')) {
            $machine_name=$request->machine_name;
            $machine_id=$request->machine_id;
            $image = $request->file('file_name');
         
            foreach($image as $files){
            $destinationPath = 'Attachments/Machines Attachments/'.$machine_name;
            $file_name =$files->getClientOriginalName();
            $files->move($destinationPath, $file_name);

            $file= new MachinesAttachments();
            $file->file_name=$file_name;
            $file->machine_id=$machine_id;
            $file->save();
            }
            session()->flash('created',"L'image a été créée");
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function show(MachinesAttachments $machinesAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit(MachinesAttachments $machinesAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MachinesAttachments $machinesAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(MachinesAttachments $machinesAttachments)
    {
        //
    }
}
