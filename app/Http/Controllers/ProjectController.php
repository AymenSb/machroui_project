<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\ProjectAttachments;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        $projects=project::all();
        return view('projects/index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories=Category::all();
        return view('projects/create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        project::create([
            'name' => $request->name,
            'type' => $request->type,
            'informations' => $request->informations,
        

        ]);
        if ($request->hasFile('image')) {
            $project_id = project::latest()->first()->id;
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Projects Attachments/' . $request->name;
                $file_name = $files->getClientOriginalName();
                $files->move($destinationPath, $file_name);

                $file = new ProjectAttachments();
                $file->file_name = $file_name;
                $file->project_id = $project_id;
                $file->save();

            }

        }

        session()->flash('add', 'Le projet a été ajoutée avec succès');
        return redirect('/project');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   $categories=Category::all();
        $project = project::findOrFail($id);
        $images = ProjectAttachments::where('project_id', $id)->get();
        return view('projects/show', compact('project', 'images','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, project $project)
    {
        $id = $request->id;
        $machine = project::findOrFail($id);
        $images = ProjectAttachments::where('project_id', $id)->get();
        $old_name = $machine->name;
        $machine->update([
            'name' => $request->name,
            'type' => $request->type,
            'informations' => $request->informations,
      
        ]);
        $new_name = $machine->name;
        if (!empty($images)) {
            if(Storage::disk('projects_uploads')->files($old_name)){
                if($old_name!=$new_name)
            Storage::disk('projects_uploads')->rename($old_name, $new_name);}
        }
       

        
        
        session()->flash('updated', "le projet a été mise à jour");
        return redirect('/project');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $project = project::findOrFail($request->project_id);
        $file = ProjectAttachments::where('project_id', $request->project_id)->first();
        if (!empty($file->project_id)) {
            Storage::disk('projects_uploads')->deleteDirectory($project->name);
        }
        $project->delete();
        session()->flash('delete', 'Projet supprimé');
        return redirect('/project');
    }

    public function viewfile_project($project_name,$file_name){
        $file=Storage::disk('projects_uploads')->getDriver()->getAdapter()->applyPathPrefix($project_name.'/'.$file_name);
        return response()->file($file);
    }
    public function download_project($project_name,$file_name){
        $file=Storage::disk('projects_uploads')->getDriver()->getAdapter()->applyPathPrefix($project_name.'/'.$file_name);
        return response()->download($file);
    }
    public function deletefile_project(Request $request){
        $image=ProjectAttachments::findOrfail($request->file_id);
        $project_name=project::where('id',$request->project_id)->pluck('name')->first();
        $image->delete();
        Storage::disk('projects_uploads')->delete($project_name.'/'.$request->file_name);
        session()->flash('delete','La photo a été supprimée');
        return back();

    }
}
