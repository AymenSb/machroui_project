<?php

namespace App\Http\Controllers;

use App\Models\subcategory;
use App\Models\formations;
use App\Models\machines;
use App\Models\rawMaterials;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
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
        $subcategory=new subcategory();
        $subcategory->name=$request->name;
        $subcategory->category_id=$request->category_id;
        $subcategory->slug=str_slug($request->name);
        $latestSlug=subcategory::whereRaw("slug RLIKE'^{$subcategory->slug}(-[0-9])?$'")->latest('id')->value('slug');
        if($latestSlug){
            $pieces=explode('-',$latestSlug);
            $number=intval(end($pieces));
            $subcategory->slug .='-'.($number+1);
        }
        $subcategory->save();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function show(subcategory $subcategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function edit(subcategory $subcategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, subcategory $subcategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\subcategory  $subcategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(subcategory $subcategory)
    {
        //
    }

    public function addToSub(Request $request){
        // echo($request->subcategory_id.'<=>'.$request->formation_id);
        if($request->formation){
        $subcategory=subcategory::where('id',$request->subcategory)->first();
        $formation=formations::where('id',$request->formation)->first();
        $subcategory->formations()->syncWithoutDetaching($formation);
        }

        if($request->machine){
            $subcategory=subcategory::where('id',$request->subcategory)->first();
            $machine=machines::where('id',$request->machine)->first();
            $subcategory->machines()->syncWithoutDetaching($machine);
        }
        if($request->material){
            $subcategory=subcategory::where('id',$request->subcategory)->first();
            $material=rawMaterials::where('id',$request->material)->first();
            $subcategory->materials()->syncWithoutDetaching($material);
        }
    return back();
        
    }
}
