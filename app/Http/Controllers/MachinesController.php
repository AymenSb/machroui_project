<?php

namespace App\Http\Controllers;

use App\Models\machines;
use Illuminate\Http\Request;

class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('machines/machines/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('machines/machines/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function show(machines $machines)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function edit(machines $machines)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, machines $machines)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function destroy(machines $machines)
    {
        //
    }
}
