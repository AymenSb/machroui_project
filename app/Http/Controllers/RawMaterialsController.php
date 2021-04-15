<?php

namespace App\Http\Controllers;

use App\Models\rawMaterials;
use App\Models\rawmaterials_attachments;
use Illuminate\Http\Request;
use File;


class RawMaterialsController extends Controller
{
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
        return view('rawmaterials/create');
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
            $material_id = rawMaterials::latest()->first()->id;
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();

            $attachment = new rawmaterials_attachments();
            $attachment->file_name = $file_name;
            $attachment->material_id = $material_id;
            $attachment->save();


            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('Attachments/Matières premières Attachments/' .$request->name ), $imageName);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {   $material=rawMaterials::where('id',$id)->first();
        $image=rawmaterials_attachments::where('material_id',$id)->get();
        return view('rawmaterials/show',compact('material','image'));
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
        $image=rawmaterials_attachments::where('material_id',$request->id)->pluck('file_name')->first();
        $file=$image;
        $old_name=$material->name;
        
        $material->update([
            'name'=>$request->name,
            'brand'=>$request->brand,
            'description'=>$request->description,
            'price'=>$request->price,  
        ]);
       
        $new_name=$material->name;
        if($file){
        $old_path=public_path('Attachments/Matières premières Attachments/'.$old_name,$file);
        $new_path=public_path('Attachments/Matières premières Attachments/'.$new_name,$file);
        File::move($old_path, $new_path);}
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function destroy(rawMaterials $rawMaterials)
    {
        //
    }
}
