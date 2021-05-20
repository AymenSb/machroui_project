<?php

namespace App\Http\Controllers;

use App\Models\ProjectAttachments;
use App\Models\project;
use Illuminate\Http\Request;

class ProjectAttachmentsController extends Controller
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
            $project_name=$request->project_name;
            $project_id=$request->project_id;
            $project=project::findOrFail($project_id);
            $image = $request->file('file_name');
            $old_data=$project->images;
            $old_base64Urls=$project->base64Urls;


         
            foreach($image as $files){
            $destinationPath = 'Attachments/Projects Attachments/'.$project_name;
            $file_name =$files->getClientOriginalName();
            $file_extension=$files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $base64Image=base64_encode(file_get_contents('Attachments/Projects Attachments/'.$project_name.'/'.$file_name));
            $image64Url="data:image/".$file_extension.";base64,".$base64Image;
            $data[]=$file_name;
            $base64Urls[]=$image64Url;  
            
            }
            $new_data=array_unique(array_merge($data,$old_data),SORT_REGULAR);
            $new_base64Urls=array_unique(array_merge($base64Urls,$old_base64Urls),SORT_REGULAR);
            
            $project->update([
                'images'=>$new_data,
                'base64Urls'=>$new_base64Urls,
            ]);         
        }
        session()->flash('created',"L'image a été créée");
        return back();
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProjectAttachments  $projectAttachments
     * @return \Illuminate\Http\Response
     */
    public function show(ProjectAttachments $projectAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProjectAttachments  $projectAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit(ProjectAttachments $projectAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProjectAttachments  $projectAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProjectAttachments $projectAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProjectAttachments  $projectAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProjectAttachments $projectAttachments)
    {
        //
    }
}
