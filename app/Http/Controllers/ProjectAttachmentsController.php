<?php

namespace App\Http\Controllers;

use App\Models\ProjectAttachments;
use App\Models\project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


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
        $pdf=$request->File('file_name');
        $new_file=$pdf->getClientOriginalName();
        $project_id=$request->project_id;
        $project_name=$request->project_name; 

        $project=project::findOrFail($project_id);
        $old_file=$project->pdf_file;
        if(!empty($old_file)){
            Storage::disk('projects_uploads')->delete($project_name.'/Cahier de charge/'.$old_file);
        }
        $request->file_name->move(public_path('Attachments/Projects Attachments/' .$project_name .'/Cahier de charge/'), $new_file);
        $base64PDF=base64_encode(file_get_contents(public_path('Attachments/Projects Attachments/' .$project_name.'/Cahier de charge/'.$new_file)));
        $file_extension=$pdf->getClientOriginalExtension();
        $pdf64Url="data:application/".$file_extension.";base64,".$base64PDF;
        $project->update([
            'pdf_file'=>$new_file,
            'pdf_base64'=>$pdf64Url,
        ]);

        return back();
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
