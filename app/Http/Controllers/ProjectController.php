<?php

namespace App\Http\Controllers;

use App\Models\project;
use App\Models\Category;
use App\Models\subcategory;
use App\Models\ProjectAttachments;
use App\Models\ProjectComments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProjectController extends Controller
{

    function __construct()
    {
    $this->middleware('permission:projet|crée projet|modifier projet|effacer projet', ['only' => ['index','show']]);
    $this->middleware('permission:crée projet', ['only' => ['create','store']]);
    $this->middleware('permission:modifier projet', ['only' => ['edit','update']]);
    $this->middleware('permission:effacer projet', ['only' => ['destroy']]);
    }
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
        $comments=ProjectComments::all();
        return view('projects/create',compact('categories','comments'));
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
            'project_type' => $request->type,
            'informations' => $request->informations,
        ]);


        if ($request->hasFile('image')) {
            $project = project::latest()->first();
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Projects Attachments/' . $request->name;
                $file_name = $files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $base64Image=base64_encode(file_get_contents($destinationPath.'/'.$file_name));
                $file_extension=$files->getClientOriginalExtension();
                $image64Url="data:image/".$file_extension.";base64,".$base64Image;
                $data[]=$file_name;
                $allImages[]=$image64Url;
            }

            $project->update([
                'images'=>$data,
                'base64Urls'=>$allImages,
            ]);

        }
        if($request->hasFile('pdf')){
            $project = project::latest()->first();
            $pdf = $request->file('pdf');
            $destinationPath = 'Attachments/Projects Attachments/' . $request->name.'/Cahier de charge';
            $file_name = $pdf->getClientOriginalName();
            $pdf->move($destinationPath, $file_name);
            $pdf_To_Base64=base64_encode(file_get_contents($destinationPath.'/'.$file_name));
            $file_extension=$pdf->getClientOriginalExtension();
            $pdf_Base64="data:application/".$file_extension.";base64,".$pdf_To_Base64;
            
            $project->update([
                'pdf_file'=>$file_name,
                'pdf_base64'=>$pdf_Base64
            ]);
        }
        
        if($request->category){
            if($request->subcategory){
                $project=project::latest()->first();
                foreach($request->subcategory as $subcategory_id){
                    $subcategory=subcategory::where('id',$subcategory_id)->first();
                    $subcategory->projects()->syncWithoutDetaching($project);
                }
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
        $images = ProjectAttachments::where('project_id', $id)->first();
        $comments = ProjectComments::where('project_id', $id)->get();
        return view('projects/show', compact('project', 'images','categories','comments'));
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
            'project_type' => $request->type,
            'informations' => $request->informations,
      
        ]);
        $new_name = $machine->name;
        if (!empty($images)) {
            if(Storage::disk('projects_uploads')->files($old_name)){
                if($old_name!=$new_name)
            Storage::disk('projects_uploads')->rename($old_name, $new_name);}
        }
       
        if($request->category){
            if($request->subcategory){
             $project=project::where('id',$request->id)->first();    
             $delete_relations=DB::table('project_subcategory')
                                    ->whereIn('project_id',[$request->id])->delete();
                                    
            foreach($request->subcategory as $subcategory_id){
                $subcategory=subcategory::where('id',$subcategory_id)->first();
                $subcategory->projects()->syncWithoutDetaching($project);
            }
            }
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
        if ($project->images) {
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
        $project=project::findOrfail($request->project_id);
        $project_name=$project->name;
        $data= $project->images;
        $base64Urls=$project->base64Urls;

        $destinationPath = 'Attachments/Projects Attachments/'.$project_name.'/'.$request->file_name;
        $path_info=pathinfo($destinationPath);
        $file_extension=$path_info['extension'];
        $base64Image=base64_encode(file_get_contents($destinationPath));
        $image64Url="data:image/".$file_extension.";base64,".$base64Image;
        Storage::disk('projects_uploads')->delete($project_name.'/'.$request->file_name);
      
        if (($key = array_search($request->file_name, $data)) !== false) {
            unset($data[$key]);
        }

        if(($key = array_search($image64Url,$base64Urls))!==false){
            unset($base64Urls[$key]);
        }

        $project->update([
            'images'=>array_values($data),
            'base64Urls'=>array_values($base64Urls),
            ]);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }

    public function viewPdfFile($project_name,$file_name){
        $file=Storage::disk('projects_uploads')->getDriver()->getAdapter()->applyPathPrefix($project_name.'/Cahier de charge/'.$file_name);
        return response()->file($file);
    }

    public function downloadPdfFile($project_name,$file_name){
        $file=Storage::disk('projects_uploads')->getDriver()->getAdapter()->applyPathPrefix($project_name.'/Cahier de charge/'.$file_name);
        return response()->download($file);
    }



    //APIs

    function getAllProjects(){
        $projects=project::all();
        return response()->json($projects);
                    
    }


    function getProjectById($id){
        $projects=project::where('id',$id)->first();
        return response()->json($projects);
    }

    public function getProjectsBySubCategories($id){
        $projects=project::
                    join('project_subcategory','projects.id','project_subcategory.project_id')
                    ->where('project_subcategory.subcategory_id',$id)
                    ->select('projects.*')
                    ->get();
        return $projects;
    }

    public function getProjectsByCategories($id){
        $projects=project::
        join('project_subcategory','projects.id','project_subcategory.project_id')
            ->join('subcategories', 'project_subcategory.subcategory_id', 'subcategories.id')
            ->where('subcategories.category_id', $id)
            ->select('projects.*')
            ->distinct('projects.id')
            ->get();
        return $projects;
    }

    public function ProjectSucategories($id){
        $project = project::where('id', $id)->first();
        if ($project != null) {
            $subcategories = $project->subcategory()->select('name', 'subcategory_id')->get();
            return $subcategories;
        } else {
            return response()->json('Empty');
        }
    }

    public function ProjectCategory($id){
        $project = project::where('id', $id)->first();
        if ($project != null) {
            $subcategories = $project->subcategory()->get();
            if($subcategories != '[]'){
                foreach($subcategories as $subcategory){
                    $category=Category::where('id',$subcategory->category_id)->first()->name;
                    
                }
                return response()->json($category);
            }
            else {
                return response()->json('Empty');
            } 
        } else {
            return response()->json('Empty');
        }
    }
}
