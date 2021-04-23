<?php

namespace App\Http\Controllers;

use App\Models\ProjectAttachments;
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
            $image = $request->file('file_name');
         
            foreach($image as $files){
            $destinationPath = 'Attachments/Projects Attachments/'.$project_name;
            $file_name =$files->getClientOriginalName();
            $files->move($destinationPath, $file_name);

            $file= new ProjectAttachments();
            $file->file_name=$file_name;
            $file->project_id=$project_id;
            $file->save();
            }
            session()->flash('created',"L'image a été créée");
            return back();
        }
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
