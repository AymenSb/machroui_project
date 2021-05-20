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
            $material=rawMaterials::latest()->first();
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Raw Materials Attachments/'.$request->name;
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $base64Image=base64_encode(file_get_contents($destinationPath.'/'.$file_name));
                $file_extension=$files->getClientOriginalExtension();
                $image64Url="data:image/".$file_extension.";base64,".$base64Image;
                $data[]=$file_name;
                $allImages[]=$image64Url;
            }
            $material->update([
                'images'=>$data,
                'base64Urls'=>$allImages,
            ]);
        }

        else{
            $material=rawMaterials::latest()->first();
            $material->update([
                'images'=>[],
                'base64Urls'=>[],
            ]);
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
        if($material->images){
            
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
        $material=rawMaterials::findOrfail($request->material_id);
        $material_name=$material->name;
        $images= $material->images;
        $base64Urls=$material->base64Urls;

        $destinationPath = 'Attachments/Raw Materials Attachments/'.$material_name.'/'.$request->file_name;
        $path_info=pathinfo($destinationPath);
        $file_extension=$path_info['extension'];
        $base64Image=base64_encode(file_get_contents($destinationPath));
        $image64Url="data:image/".$file_extension.";base64,".$base64Image;
        Storage::disk('materials_uploads')->delete($material_name.'/'.$request->file_name);
        if (($key = array_search($request->file_name, $images)) !== false) {
            unset($images[$key]);
        }
        if(($key = array_search($image64Url,$base64Urls))!==false){
            unset($base64Urls[$key]);
        }
        $material->update([
            'images'=>array_values($images),
            'base64Urls'=>array_values($base64Urls),
        ]);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }


    
    function getMaterials(){
        $raw_materials=rawMaterials::all();
        return response()->json($raw_materials);
    }
}

