<?php

namespace App\Http\Controllers;

use App\Models\services_attachments;
use Illuminate\Http\Request;

class ServicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            $service_name=$request->service_name;
            $service_id=$request->service_id;
            $image = $request->file('file_name');
            $services_attachments=services_attachments::where('service_id',$service_id)->first();
            $old_data=$services_attachments->file_name;
            foreach($image as $files){
            $destinationPath = 'Attachments/Services Attachments/'.$service_name;
            $file_name =$files->getClientOriginalName();
            $files->move($destinationPath, $file_name);
            $data[]=$file_name;
            }
            $new_data=array_unique(array_merge($data,$old_data),SORT_REGULAR);
            $services_attachments->update([
                'file_name'=>$new_data
            ]);   
            session()->flash('created',"L'image a été créée");
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\services_attachments  $services_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(services_attachments $services_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\services_attachments  $services_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(services_attachments $services_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\services_attachments  $services_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, services_attachments $services_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\services_attachments  $services_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(services_attachments $services_attachments)
    {
        //
    }
}
