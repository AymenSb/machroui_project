<?php

namespace App\Http\Controllers;

use App\Models\rawmaterials_attachments;
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
            $image = $request->file('file_name');
            $rawmaterials_attachments=rawmaterials_attachments::where('material_id',$material_id)->first();
            $old_data=$rawmaterials_attachments->file_name;
         
            foreach($image as $files){
            $destinationPath = 'Attachments/Raw Materials Attachments/'.$material_name;
            $file_name =$files->getClientOriginalName();
            $files->move($destinationPath, $file_name);
            $data[]=$file_name;
          
            }
            $new_data=array_unique(array_merge($data,$old_data),SORT_REGULAR);
            $rawmaterials_attachments->update([
                'file_name'=>$new_data
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
