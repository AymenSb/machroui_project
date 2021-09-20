<?php

namespace App\Http\Controllers;

use App\Models\formations_requests;
use App\Models\ClientNotifications;
use Illuminate\Http\Request;
use App\Models\formations;
use Illuminate\Support\Facades\DB ;

use Validator;



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
    public function update(Request $request)
    {
        $subscriber=formations_requests::findOrfail($request->request_id);
        $client_id=$subscriber->client_id;
        $formation_id=$subscriber->formation_id;
        $formation=formations::where('id',$formation_id)->first();
        $subscriber->update([
            "Accepted"=>1
        ]);

        ClientNotifications::create([
            'title'=>'Demande de formation acceptée',
            'subtitle'=>'Veuillez confirmer votre arrivée pour la formation '.$formation->name.'.',
            'image'=>'test',
            'link'=>'/account/submited-formations',
            'client_id'=>$client_id,
        ]);
        
        session()->flash('edit', 'Abonné ajouter');
        return redirect('formations/'.$formation_id);
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
        $isComing=$subscriber->IsComing;
        if($isComing==1){
            $formation=formations::findOrfail($subscriber->formation_id);
            $formation->update([
                'participants'=>$formation->participants -1,
            ]);

            $subscriber->delete();
            
           session()->flash('edit', 'Abonné supprimer');
           return redirect('formations/'.$formation_id);
        }
        else{
            $subscriber->delete();

            session()->flash('edit', 'Abonné supprimer');
            return redirect('formations/'.$formation_id);
        }
        
    }


    //API client request
    public function formationsRequests(Request $request){

        formations_requests::create([
            "client_id"=>$request->client_id,
            "client_name"=>$request->client_name,
            "client_surname"=>$request->client_surname,
            "client_email"=>$request->client_email,
            "client_number"=>$request->client_number,
            "formation_id"=>$request->formation_id,
        ]);
        return response()->json([
            'message'=>'Votre demande à été envoyé.'
        ]);

    }

    public function ClientFormations($client_id){   
        $client_formations=DB::table('formations_requests')
                        ->join('formations','formations.id','formations_requests.formation_id')
                        ->select('formations.*','formations_requests.*')
                        ->where('Accepted',1)
                        ->where('client_id',$client_id)
                        ->get();
        return $client_formations;                                                
    }

    function ClientConfirmed(Request $request){
        $formation_request=formations_requests::where('id',$request->id)->first();
        $formation_request->update([
            'IsComing'=>1
        ]);
        $formation=formations::where('id',$formation_request->formation_id)->first();
        $formation->update([
            "participants"=>$formation->participants+1
        ]);
        return response()->json([
            'message'=>'vous avez confirmer votre postulation.',
        ]);
    }

    function ClientDeclined(Request $request){
        $formation_request=formations_requests::where('id',$request->id)->first();
        $formation_request->delete();
        return response()->json([
            'message'=>'vous avez supprimer votre postulation.'
        ]);
    }
}
