<?php

namespace App\Http\Controllers;

use App\Models\formations_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FormationsAttachmentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(formations_attachment $formations_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(formations_attachment $formations_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formations_attachment $formations_attachment)
    {
        
         $image=$request->File('file_name');
         $new_file=$image->getClientOriginalName();

        $formation_id=$request->formation_id;
        $formation_name=$request->formation_name;
        $attachment=formations_attachment::where('formation_id',$formation_id)->first();
        $old_file=$attachment->file_name;


        if(!empty($old_file)){
            Storage::disk('public_uploads')->delete($formation_name.'/'.$old_file);
        }
        $request->file_name->move(public_path('Attachments/Formations Attachments/' .$formation_name ), $new_file);


        $base64Image=base64_encode(file_get_contents(public_path('Attachments/Formations Attachments/' .$formation_name.'/'.$new_file)));
        $file_extension=$image->getClientOriginalExtension();
        $image64Url="data:image/".$file_extension.";base64,".$base64Image;
        $attachment->update([
            'file_name'=>$new_file,
            'base64Urls'=>$image64Url,
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(formations_attachment $formations_attachment)
    {
        //
    }
}
