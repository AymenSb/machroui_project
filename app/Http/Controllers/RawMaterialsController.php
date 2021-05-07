<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use App\Models\rawMaterials;
use App\Models\rawmaterials_attachments;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;



class RawMaterialsController extends Controller
{

    function __construct()
    {
    $this->middleware('permission:matières premières|crée matière première|modfier matière première|effacer matière première', ['only' => ['index','show']]);
    $this->middleware('permission:crée matière première', ['only' => ['create','store']]);
    $this->middleware('permission:modfier matière première', ['only' => ['edit','update']]);
    $this->middleware('permission:effacer matière première', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {    $materials=rawMaterials::all();
        return view('rawmaterials/index',compact('materials'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {     
        $categories = Category::all();
        return view('rawmaterials/create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        rawMaterials::create([
            'name'=>$request->name,
            'description'=>$request->description,
            'price'=>$request->price,
            'brand'=>$request->brand,
        ]);
        if ($request->hasFile('image')) {
            $material_id=rawMaterials::latest()->first()->id;
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Raw Materials Attachments/'.$request->name;
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $data[]=$file_name;
            }
            $file= new rawmaterials_attachments();
            $file->file_name=$data;
            $file->material_id=$material_id;
            $file->save();
        }

        else{
            $material_id=rawMaterials::latest()->first()->id;
            $file= new rawmaterials_attachments();
            $file->file_name=[];
            $file->material_id=$material_id;
            $file->save();
        }

        if($request->category){
            if($request->subcategory){
              $subcategory=subcategory::where('id',$request->subcategory)->first();
              $material=rawMaterials::latest()->first();
              $subcategory->materials()->syncWithoutDetaching($material);
            }
        }
        session()->flash('add','la matière première a été ajoutée');
        return redirect('rawmaterials');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   
        $categories=Category::all();
        $material=rawMaterials::where('id',$id)->first();
        $images=rawmaterials_attachments::where('material_id',$id)->first();
        return view('rawmaterials/show',compact('material','images','categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function edit(rawMaterials $rawMaterials)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rawMaterials $rawMaterials)
    {
        $material=rawMaterials::findOrFail($request->id);
        $images=rawmaterials_attachments::where('material_id',$request->id)->first();
        $old_name=$material->name;
        
        $material->update([
            'name'=>$request->name,
            'brand'=>$request->brand,
            'description'=>$request->description,
            'price'=>$request->price,  
        ]);
        $new_name=$material->name;
        if($old_name!=$new_name){
            if($images){
                Storage::disk('materials_uploads')->rename($old_name,$new_name);
            }
        }
        if($request->category){
            if($request->subcategory){
            $subcategory=subcategory::where('id',$request->subcategory)->first();
             $material=rawMaterials::where('id',$request->id)->first();    
              $material->subcategory()->sync($material);
            }
        }
        
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $material=rawMaterials::findOrFail($request->machine_id);
        $file=rawmaterials_attachments::where('material_id',$request->machine_id)->first();
        if(!empty($file->machine_id)){
            
            Storage::disk('materials_uploads')->deleteDirectory($material->name);     
        }
        $material->delete();
        session()->flash('delete','machine has been deleted');
        return redirect('/rawmaterials');
    }

    public function viewfile_material($material_name,$file_name){
        
        $file=Storage::disk('materials_uploads')->getDriver()->getAdapter()->applyPathPrefix($material_name.'/'.$file_name);
        return response()->file($file);
    }

    public function downloadMaterial($material_name,$file_name){
        $file=Storage::disk('materials_uploads')->getDriver()->getAdapter()->applyPathPrefix($material_name.'/'.$file_name);
        return response()->download($file);
    }

    public function deletefile_material(Request $request){
        $image=rawmaterials_attachments::findOrfail($request->file_id);
        $material_name=rawMaterials::where('id',$request->machine_id)->pluck('name')->first();
        $data= $image->file_name;
        Storage::disk('materials_uploads')->delete($material_name.'/'.$request->file_name);
        if (($key = array_search($request->file_name, $data)) !== false) {
            unset($data[$key]);
        }
        $image->update([
            'file_name'=>array_values($data),
        ]);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }


    
    function getMaterials(){
        $raw_materials=DB::table('raw_materials')
        ->join('rawmaterials_attachments','raw_materials.id','rawmaterials_attachments.material_id')
        ->select('raw_materials.*','rawmaterials_attachments.file_name')
        ->get();
        return response()->json($raw_materials);
    }
}

