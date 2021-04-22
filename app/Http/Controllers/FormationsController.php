<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use App\Models\formations;
use App\Models\formations_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use File;
use Illuminate\Support\Facades\Storage;


class FormationsController extends Controller
{   
     function __construct()
 {
 $this->middleware('permission:formations|crée formation|modfier formation|effacer formation', ['only' => ['index','show']]);
 $this->middleware('permission:crée formation', ['only' => ['create','store']]);
 $this->middleware('permission:modfier formation', ['only' => ['edit','update']]);
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
                'name.unique'=>'Une formation à cette date deja existe existe déjà',
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

            $attachments = new formations_attachment();
            $attachments->file_name = $file_name;
            $attachments->formation_id = $formation_id;
            $attachments->save();


            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('Attachments/Formations Attachments/' .$request->name ), $imageName);
        }
        if($request->category){
            if($request->subcategory){
               $subcategory=subcategory::where('id',$request->subcategory)->first();
             $formation=Formations::latest()->first();

             echo $subcategory->id.'-----'.$formation->id;
               $subcategory->formations()->syncWithoutDetaching($formation);
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
        $attachments=formations_attachment::where('formation_id',"=",$id)->get();
        return view('formations.show', ['formation' => $formations],['attachments'=>$attachments]);
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
        echo $id;
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
            $subcategory=subcategory::where('id',$request->subcategory)->first();
             $formation=Formations::where('id',$request->id)->first();
             $subcategory->formations()->sync($formation);
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
            echo('works');
            Storage::disk('public_uploads')->deleteDirectory($formation->name);
           
            
        }
        $formation->delete();
        session()->flash('delete','formation has been deleted');
        return redirect('/formations');
    }

   
}
