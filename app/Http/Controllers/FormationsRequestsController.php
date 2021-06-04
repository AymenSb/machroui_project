<?php

namespace App\Http\Controllers;

use App\Models\formations_requests;
use Illuminate\Http\Request;
use App\Models\formations;


class FormationsRequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $requests=formations_requests::where('Accpted',0)->get();
        return view('formations/requests/index',compact('requests'));
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
     * @param  \App\Models\formations_requests  $formations_requests
     * @return \Illuminate\Http\Response
     */
    public function show(formations_requests $formations_requests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formations_requests  $formations_requests
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id =$request->request_id;
        $formation_request=formations_requests::findOrfail($id);
        $formation_request->update([
            'Accpted'=>1
        ]);

        $formation=formations::findOrfail($formation_request->formation_id);
        $formation->update([
            'subscribed'=>$formation->subscribed+1,
        ]);
        session()->flash('Add', 'Demande acceptée');
        return redirect('formations-requests');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formations_requests  $formations_requests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formations_requests $formations_requests)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formations_requests  $formations_requests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $subscriber=formations_requests::findOrfail($request->request_id);
        $formation_id=$subscriber->formation_id;
        $accepted=$subscriber->Accpted;
        if($accepted==1){
            $formation=formations::findOrfail($subscriber->formation_id);
            $formation->update([
                'subscribed'=>$formation->subscribed -1,
            ]);
        }

        $subscriber->delete();

        session()->flash('edit', 'Abonné supprimer');
        return redirect('formations/'.$formation_id);
    }
}
