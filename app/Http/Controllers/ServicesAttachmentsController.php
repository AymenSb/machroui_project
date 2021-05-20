<?php

namespace App\Http\Controllers;

use App\Models\services_attachments;
use App\Models\services;
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
            $service=services::findOrfail($service_id);
            $image = $request->file('file_name');
            $old_data=$service->images;
            $old_base64Urls=$service->base64Urls;

            foreach($image as $files){
            $destinationPath = 'Attachments/Services Attachments/'.$service_name;
            $file_name =$files->getClientOriginalName();
            $file_extension=$files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $base64Image=base64_encode(file_get_contents('Attachments/Services Attachments/'.$service_name.'/'.$file_name));
            $image64Url="data:image/".$file_extension.";base64,".$base64Image;
            $data[]=$file_name;
            $base64Urls[]=$image64Url;  
            }
            $new_data=array_unique(array_merge($data,$old_data),SORT_REGULAR);
            $new_base64Urls=array_unique(array_merge($base64Urls,$old_base64Urls),SORT_REGULAR);

            $service->update([
                'images'=>$new_data,
                'base64Urls'=>$new_base64Urls,
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
