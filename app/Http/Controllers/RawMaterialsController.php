<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use App\Models\rawMaterials;
use App\Models\rawmaterials_requests;
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
    // $this->middleware('permission:modfier matière première', ['only' => ['edit','update']]);
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
                'main_image'=>$allImages[0]
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
              $material=rawMaterials::latest()->first();
              foreach($request->subcategory as $subcategory_id){
                $subcategory=subcategory::where('id',$subcategory_id)->first();
                $subcategory->materials()->syncWithoutDetaching($material);
            }
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
        $requests=rawmaterials_requests::where('rawmaterial_id',$id)->where('Accpted',1)->get();
        return view('rawmaterials/show',compact('material','images','categories','requests'));
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
             $material=rawMaterials::where('id',$request->id)->first();    
             $delete_relations=DB::table('raw_materials_subcategory')
                                    ->whereIn('raw_materials_id',[$request->id])->delete();
                                    
            foreach($request->subcategory as $subcategory_id){
                $subcategory=subcategory::where('id',$subcategory_id)->first();
                $subcategory->materials()->syncWithoutDetaching($material);
            }
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
        if($base64Urls){
            $material->update([
                'images'=>array_values($images),
                'base64Urls'=>array_values($base64Urls),
                'main_image'=>$base64Urls[1],
            ]);
        }

        else{
            $material->update([
                'images'=>array_values($images),
                'base64Urls'=>array_values($base64Urls),
                'main_image'=>'',  
            ]);
        }
        
        session()->flash('delete','La photo a été supprimée');
        return back();
    }


    
    function getMaterials(){
        $raw_materials=rawMaterials::all();
        return response()->json($raw_materials);
    }

    function getMaterialById($id){
        $raw_material=rawMaterials::where('id',$id)->first();
        return response()->json($raw_material);
    }

    function getSubCategoriesRawMaterials($id){
        $raw_material=rawMaterials::where('id',$id)->first();
        if($raw_material!=null){
            $subcategories=$raw_material->subcategory()->select('name','subcategory_id')->get();
            return $subcategories;
        }
        else {
            return response()->json('Empty');
        }
    }
    public function MaterialCategory($id){
        $raw_material = rawMaterials::where('id', $id)->first();
        if ($raw_material != null) {
            $subcategories = $raw_material->subcategory()->get();
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

    function getAllCategoriesForMaterials($id){
        $raw_material=rawMaterials::
                        join('raw_materials_subcategory','raw_materials.id','raw_materials_subcategory.raw_materials_id')
                        ->join('subcategories','raw_materials_subcategory.subcategory_id','subcategories.id')
                        ->where('subcategories.category_id',$id)
                        ->select('raw_materials.*')
                        ->distinct('raw_materials.id')
                        ->get();
                        return response()->json($raw_material);
    }

    function getMaterialsCat($id){
        $materials=rawMaterials::
        join('raw_materials_subcategory','raw_materials.id','raw_materials_subcategory.raw_materials_id')
        ->where('raw_materials_subcategory.subcategory_id',$id)
        ->select('raw_materials.*')
        ->get();
        return $materials;
    }
}

