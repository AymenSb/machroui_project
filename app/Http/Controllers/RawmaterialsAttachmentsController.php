<?php

namespace App\Http\Controllers;

use App\Models\rawmaterials_attachments;
use App\Models\rawMaterials;
use Illuminate\Http\Request;

class RawmaterialsAttachmentsController extends Controller
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
            $material_name=$request->material_name;
            $material_id=$request->material_id;
            $material=rawMaterials::findOrFail($material_id);
            $image = $request->file('file_name');
            $old_data=$material->images;
            $old_base64Urls=$material->base64Urls;
         
            foreach($image as $files){
            $destinationPath = 'Attachments/Raw Materials Attachments/'.$material_name;
            $file_name =$files->getClientOriginalName();
            $file_extension=$files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $base64Image=base64_encode(file_get_contents('Attachments/Raw Materials Attachments/'.$material_name.'/'.$file_name));
            $image64Url="data:image/".$file_extension.";base64,".$base64Image;
            $data[]=$file_name;
            $base64Urls[]=$image64Url;          
            }
            $new_data=array_unique(array_merge($data,$old_data),SORT_REGULAR);
            $new_base64Urls=array_unique(array_merge($base64Urls,$old_base64Urls),SORT_REGULAR);

            $material->update([
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
     * @param  \App\Models\rawmaterials_attachments  $rawmaterials_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(rawmaterials_attachments $rawmaterials_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rawmaterials_attachments  $rawmaterials_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(rawmaterials_attachments $rawmaterials_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rawmaterials_attachments  $rawmaterials_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rawmaterials_attachments $rawmaterials_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rawmaterials_attachments  $rawmaterials_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(rawmaterials_attachments $rawmaterials_attachments)
    {
        //
    }
}
