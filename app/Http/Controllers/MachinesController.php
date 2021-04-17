<?php

namespace App\Http\Controllers;

use App\Models\machines;
use App\Models\MachinesAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class MachinesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $machines=machines::all();
        return view('machines/machines/index',compact('machines'));
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
        if($request->state=='Nouvelle machine'){
                $statVal=2;
        }
        else {
            $statVal=1;
        }
        machines::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'details'=>$request->details,
            'characteristics'=>$request->characteristics,
            'markDetails'=>$request->markDetails,
            'state'=>$request->state,
            'stateVal'=>$statVal,
           
        ]);
        if ($request->hasFile('image')) {
            $machine_id=machines::latest()->first()->id;
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Machines Attachments/'.$request->name;
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);

                $file= new MachinesAttachments();
                $file->file_name=$file_name;
                $file->machine_id=$machine_id;
                $file->save();
                
            }
            
        }
     
        session()->flash('add','La machine a été ajoutée avec succès');
        return redirect('/machines/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine=machines::findOrFail($id);
        $images=MachinesAttachments::where('machine_id',$id)->get();      
        return view('machines/machines/show',compact('machine','images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
    { //2 = new

        //1 =used
        $id=$request->id;
        $machine=machines::findOrFail($id);
        $images=MachinesAttachments::where('machine_id',$id)->get();
        $old_name=$machine->name;
        $machine->update([
            'name'=>$request->name,
            'price'=>$request->price,
            'Vendor'=>$request->Vendor,
            'details'=>$request->details,
            'characteristics'=>$request->characteristics,
            'markDetails'=>$request->markDetails,
            'state'=>$request->state,
            'stateVal'=>$request->stateVal,
        ]);
        $new_name=$machine->name;
        if($images){
            Storage::disk('machines_uploads')->rename($old_name,$new_name);
        }
            $stateVal_new=2;
            $stateVal_used=1;
        if($request->state=='Nouvelle machine'){
           $machine->update([
            'stateVal'=>$stateVal_new,
           ]);

        }

        else {
            $stateVal=1;
            $machine->update([
             'stateVal'=>$stateVal_used,
            ]);
        }
        session()->flash('updated',"la machine a été mise à jour");
        return redirect('machines/'.$request->id);
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) 
    {
        $machine=machines::findOrFail($request->machine_id);
        $file=MachinesAttachments::where('machine_id',$request->machine_id)->first();
        if(!empty($file->machine_id)){
            echo('works');
            Storage::disk('machines_uploads')->deleteDirectory($machine->name);
           
            
        }
        $machine->delete();
        session()->flash('delete','machine has been deleted');
        return redirect('/machines');
    }

    public function indexNew(){
        $Newmachines=machines::where('stateVal',2)->get();
        return view('machines/machines/indexNew',compact('Newmachines'));
    }

    public function indexUsed(){
        $Usedmachines=machines::where('stateVal',1)->get();
        return view('machines/machines/indexUsed',compact('Usedmachines'));
    }

    public function editpage($id){
        $machine=machines::findOrfail($id);
        return view('machines/machines/edit',compact('machine'));
    }

    public function delete($id){
        $machine=machines::findOrFail($id);
        $machine->delete();
        return back();
    }


    public function viewfile($formation_name,$file_name){
        
        $file=Storage::disk('machines_uploads')->getDriver()->getAdapter()->applyPathPrefix($formation_name.'/'.$file_name);
        return response()->file($file);
    }

    public function download($formation_name,$file_name){
        $file=Storage::disk('machines_uploads')->getDriver()->getAdapter()->applyPathPrefix($formation_name.'/'.$file_name);
        return response()->download($file);
    }

    public function deletefile(Request $request){
        $image=MachinesAttachments::findOrfail($request->file_id);
        $machine_name=machines::where('id',$request->machine_id)->pluck('name')->first();
        $image->delete();
        Storage::disk('machines_uploads')->delete($machine_name.'/'.$request->file_name);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }
}
