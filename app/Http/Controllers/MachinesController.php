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
        return view('machines/machines/index');
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

        machines::create([
            'name'=>$request->name,
            'begin_date'=>$request->begin_date,
            'end_date'=>$request->end_date,
            'places'=>$request->places,
            'description'=>$request->description,
            'trainer'=>$request->trainer,
        ]);
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'files/';
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $data[] = $file_name;
            }
        }
        $file= new MachinesAttachments();
        $file->file_name=json_encode($data);
        $file->save();
        return back()->withSuccess('Great! Image has been successfully uploaded.');
    

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function show(machines $machines)
    {
        //
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
