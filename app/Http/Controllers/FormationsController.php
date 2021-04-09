<?php

namespace App\Http\Controllers;

use App\Models\formations;
use App\Models\formations_attachment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB ;
use File;

class FormationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   $formations=formations::all();
        return view('formations.index',compact('formations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('formations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   

        $request->validate([
            'name' => 'unique:formations|max:255',
        ],
            [
                'name.unique'=>'Cette formation existe déjà',
            ]
        );
        
        formations::create([
            'name'=>$request->name,
            'begin_date'=>$request->begin_date,
            'end_date'=>$request->end_date,
            'places'=>$request->places,
            'description'=>$request->description,
            'trainer'=>$request->trainer,
        ]);

        if ($request->hasFile('image')) {
            $formation_id = Formations::latest()->first()->id;
            $image = $request->file('image');
            $file_name = $image->getClientOriginalName();

            $attachments = new formations_attachment();
            $attachments->file_name = $file_name;
            $attachments->formation_id = $formation_id;
            $attachments->save();


            $imageName = $request->image->getClientOriginalName();
            $request->image->move(public_path('Attachments/Formations Attachments/' .$request->name ), $imageName);
        }

        session()->flash('Add', 'Formation ajoutée avec succès');
        return redirect('formations/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $formations = Formations::where('id', '=', $id)->first();
        if($formations==null){
            return redirect('/formations');
        }
        $attachments=formations_attachment::where('formation_id',"=",$id)->get();
        return view('formations.show', ['formation' => $formations],['attachments'=>$attachments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function edit(formations $formations)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, formations $formations)
    {
        $id= $request->id;
        $formations=formations::find($id);  
        $old_name=$formations->name; //get old formation name
        
        //get the file name
        $attachment=formations_attachment::where('formation_id','=',$id)->first(); 
        $file_name=$attachment->file_name;     
        if($request->name==null)
        {
            $formations->update([
                'begin_date'=>$request->begin_date,
                'end_date'=>$request->end_date,
                'description'=>$request->description,
            ]);
            return redirect('formations/'.$id.'');

        }
        else
        $formations->update([
            'name'=>$request->name,
            'trainer'=>$request->trainer,
            'places'=>$request->places,
        ]);
       
        $new_name=$formations->name;

        $old_path=public_path('Attachments/Formations Attachments/' .$old_name,$file_name);
        $new_path=public_path('Attachments/Formations Attachments/' .$new_name,$file_name);
        File::move($old_path, $new_path);


         return redirect('formations/'.$id.'');

        echo($file_name);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\formations  $formations
     * @return \Illuminate\Http\Response
     */
    public function destroy(formations $formations)
    {
        //
    }

   
}
