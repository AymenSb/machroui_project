<?php

namespace App\Http\Controllers;

use App\Models\machines;
use App\Models\MachinesAttachments;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $machines=machines::all();
        return view('machines/machines/index',compact('machines'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machines/machines/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($request->state=='Nouvelle machine'){
                $statVal=2;
        }
        else {
            $statVal=1;
        }
        machines::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'details'=>$request->details,
            'characteristics'=>$request->characteristics,
            'markDetails'=>$request->markDetails,
            'state'=>$request->state,
            'stateVal'=>$statVal,
           
        ]);
        if ($request->hasFile('image')) {
            $machine_id=machines::latest()->first()->id;
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Machines Attachments/'.$request->name;
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $data[] = $file_name;
            }
        }
        $file= new MachinesAttachments();
        $file->file_name=json_encode($data);
        $file->machine_id=$machine_id;
        $file->save();
        return back()->withSuccess('Great! Image has been successfully uploaded.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine=machines::findOrFail($id);
        $images=MachinesAttachments::where('machine_id',$id)->pluck('file_name');
        $files=json_decode($images,true);
        
       if($machine==null){
        return redirect('/machines');
        }
        return view('machines/machines/show',compact('machine','files'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function edit(machines $machines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, machines $machines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function destroy(machines $machines)
    {
        //
    }
}
