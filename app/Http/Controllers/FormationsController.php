<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use App\Models\formations;
use App\Models\formations_attachment;
use App\Models\formations_requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use File;
use Illuminate\Support\Facades\Storage;


class FormationsController extends Controller
{   
     function __construct()
 {
 $this->middleware('permission:formations|crée formation|modifier formation|effacer formation', ['only' => ['index','show']]);
 $this->middleware('permission:crée formation', ['only' => ['create','store']]);
 $this->middleware('permission:modifier formation', ['only' => ['edit','update']]);
 $this->middleware('permission:effacer formation', ['only' => ['destroy']]);
 }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $formations=formations::all();
        return view('formations.index',compact('formations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   $categories=Category::all();
        return view('formations.create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate([
            'begin_date' => 'unique:formations|max:255',
        ],
            [
                'begin_date.unique'=>'Une formation à cette date deja existe existe déjà',
            ]
        );
        
        formations::create([
            'name'=>$request->name,
            'begin_date'=>$request->begin_date,
            'places'=>$request->places,
            'description'=>$request->description,
            'trainer'=>$request->trainer,
            'locale'=>$request->locale,
            'link'=>$request->link,
            'price'=>$request->price,
            'plan'=>$request->plan,
        ]);

        if ($request->hasFile('image')) {
            $formation_id = Formations::latest()->first()->id;
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();
            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('Attachments/Formations Attachments/' .$request->name ), $imageName);

            $base64Image=base64_encode(file_get_contents(public_path('Attachments/Formations Attachments/' .$request->name.'/'.$imageName)));
            $file_extension=$request->image->getClientOriginalExtension();
            $image64Url="data:image/".$file_extension.";base64,".$base64Image;

            $attachments = new formations_attachment();
            $attachments->file_name = $file_name;
            $attachments->formation_id = $formation_id;
            $attachments->base64Urls=$image64Url;
            $attachments->save();


      
            
        }
        if($request->category){
            if($request->subcategory){
                $formation=Formations::latest()->first();
                foreach($request->subcategory as $subcategory_id){
                    $subcategory=subcategory::where('id',$subcategory_id)->first();
                    $subcategory->formations()->syncWithoutDetaching($formation);
                }
            }
        }

        session()->flash('Add', 'Formation ajoutée avec succès');
        return redirect('formations');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formations = Formations::where('id', '=', $id)->first();
        if($formations==null){
            return redirect('/formations');
        }
        $subscribers=formations_requests::where('formation_id',$id)
                                        ->where('Accpted',1)
                                        ->get();
        $attachments=formations_attachment::where('formation_id',"=",$id)->get();
        return view('formations.show', ['formation' => $formations],compact('subscribers','attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {      
        $categories=Category::all();
        $formation=formations::findOrFail($id);
        return view('formations/edit',compact('formation','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formations $formations)
     {
        $id= $request->id;
        $formations=formations::findOrFail($id);  
        $old_name=$formations->name; //get old formation name
        
        //get the file name
        $attachment=formations_attachment::where('formation_id','=',$id)->first();
        if($attachment){$file_name=$attachment->file_name;} 
          
        
            $formations->update([
                'name'=>$request->name,
                'begin_date'=>$request->begin_date,
                'places'=>$request->places,
                'description'=>$request->description,
                'trainer'=>$request->trainer,
                'locale'=>$request->locale,
                'link'=>$request->link,
                'price'=>$request->price,
                'plan'=>$request->plan,
            ]);
        $new_name=$formations->name;
        if(!empty($file_name)){
            if(Storage::disk('public_uploads')->files($old_name)){
                if($old_name=!$new_name)
                Storage::disk('public_uploads')->rename($old_name, $new_name);
            }
        }

 

         if($request->category){
            if($request->subcategory){
                $formation=Formations::where('id',$request->id)->first();
                $delete_relations=DB::table('formations_subcategory')
                                    ->whereIn('formations_id',[$request->id])->delete();
                foreach($request->subcategory as $subcategory_id){
                    $subcategory=subcategory::where('id',$subcategory_id)->first();
                    $subcategory->formations()->syncWithoutDetaching($formation);
                }
                
            }
        }
        
        session()->flash('edit','la formation a été mise à jour');
        return redirect('formations/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $formation=formations::findOrFail($request->formation_id);
        $file=formations_attachment::where('formation_id',$request->formation_id)->first();
        if(!empty($file->formation_id)){
            Storage::disk('public_uploads')->deleteDirectory($formation->name);            
        }
        $formation->delete();
        session()->flash('delete','formation has been deleted');
        return redirect('/formations');
    }

    function getFormations(){
        $formations=DB::table('formations')
        ->join('formations_attachments','formations.id','formations_attachments.formation_id')
        ->select('formations.*','formations_attachments.file_name','formations_attachments.base64Urls')
        ->get();
        return response()->json($formations);
    }

    function getFormationById($id){
        $formation=DB::table('formations')
        ->join('formations_attachments','formations.id','formations_attachments.formation_id')
        ->where('formations.id',$id)
        ->select('formations.*','formations_attachments.file_name','formations_attachments.base64Urls')
        ->first();
       
        return response()->json($formation);
    }

    function getFormationsCat($id){
        $formations=db::table('formations')
                    ->join('formations_attachments','formations.id','formations_attachments.formation_id')
                    ->join('formations_subcategory','formations.id','formations_subcategory.formations_id')
                    ->where('formations_subcategory.subcategory_id',$id)
                    ->select('formations.*','formations_attachments.file_name','formations_attachments.base64Urls')
                    ->get();
                    
        return response()->json($formations);
    }

    function getsubcategoriesFormations($id){
        $formation=formations::where('id',$id)->first();
        if($formation!=null){
            $subcategories=$formation->subcategory()->select('name','subcategory_id')->get();
            return $subcategories;
        }
        else {
            return response()->json('Empty');
        }
    }


    function getAllCatFormations($id){
        $formations=db::table('formations')
                        ->join('formations_attachments','formations.id','formations_attachments.formation_id')
                        ->join('formations_subcategory','formations.id','formations_subcategory.formations_id')
                        ->join('subcategories','formations_subcategory.subcategory_id','subcategories.id')
                        ->where('subcategories.category_id',$id)
                        ->select('formations.*','formations_attachments.file_name','formations_attachments.base64Urls')
                        ->distinct('formations.id')
                        ->get();
                        return response()->json($formations);
                    }

   
}
