<?php

namespace App\Http\Controllers;

use App\Models\formations_attachment;
use Illuminate\Http\Request;

class FormationsAttachmentController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function show(formations_attachment $formations_attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(formations_attachment $formations_attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formations_attachment $formations_attachment)
    {
        $id=$request->id;
        $image=$request->File('image');
        $file=$image->getClientOriginalName();
        echo($image);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formations_attachment  $formations_attachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(formations_attachment $formations_attachment)
    {
        //
    }
}
