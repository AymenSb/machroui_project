<?php

namespace App\Http\Controllers;

use App\Models\rawMaterials;
use Illuminate\Http\Request;

class RawMaterialsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rawmaterials/index');
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

            $attachments = new rawmaterials_attachments();
            $attachments->file_name = $file_name;
            $attachments->formation_id = $formation_id;
            $attachments->save();


            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('Attachments/Formations Attachments/' .$request->name ), $imageName);
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rawMaterials  $rawMaterials
     * @return \Illuminate\Http\Response
     */
    public function show(rawMaterials $rawMaterials)
    {
        //
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
        //
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
