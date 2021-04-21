<?php

namespace App\Http\Controllers;

use App\Models\services;
use App\Models\services_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicesController extends Controller
{
    function __construct()
    {
    $this->middleware('permission:gestion des services|crée service|modfier service|effacer service', ['only' => ['index','show']]);
    $this->middleware('permission:crée service', ['only' => ['create','store']]);
    $this->middleware('permission:modfier service', ['only' => ['edit','update']]);
    $this->middleware('effacer service', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $services=services::get();
        return view('services/index',compact('services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('services/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        services::create([
            'name'=>$request->name,
            'type'=>$request->type,
            'description'=>$request->description,
        ]);
        if($request->hasFile('image')){
            $service_id=services::latest()->first()->id;
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Services Attachments/'.$request->name;
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);

                $file= new services_attachments();
                $file->file_name=$file_name;
                $file->service_id=$service_id;
                $file->save();
            }
        }    
        session()->flash('ADD','le service a été créé');
        return redirect('services/create');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\services  $services
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $service=services::findOrFail($id);
        $images=services_attachments::where('service_id',$id)->get();
        return view('services/show',compact('service','images'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\services  $services
     * @return \Illuminate\Http\Response
     */
    public function edit(services $services)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\services  $services
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, services $services)
    {
        $service=services::findOrFail($request->id);
        $images=services_attachments::where('service_id',$request->id)->first();
        $old_name=$service->name;
        
        $service->update([
            'name'=>$request->name,
            'type'=>$request->type,
            'description'=>$request->description,
        ]);
        $new_name=$service->name;

        if($new_name!=$old_name){
            if($images){
                Storage::disk('services_uploads')->rename($old_name,$new_name);
            }
        }
           
        
       return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\services  $services
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $service=services::findOrFail($request->service_id);
        $file=services_attachments::where('service_id',$request->service_id)->first();
        if(!empty($file->service_id)){
            echo $file->service_id;
            Storage::disk('services_uploads')->deleteDirectory($service->name);     
        }
        $service->delete();
        session()->flash('delete','Service a été supprmier');
        return redirect('/services');
    }

    public function viewfile_service($service_name,$file_name){
        
        $file=Storage::disk('services_uploads')->getDriver()->getAdapter()->applyPathPrefix($service_name.'/'.$file_name);
        return response()->file($file);
    }

    public function download_service($service_name,$file_name){
        $file=Storage::disk('services_uploads')->getDriver()->getAdapter()->applyPathPrefix($service_name.'/'.$file_name);
        return response()->download($file);
    }

    public function deletefile_service(Request $request){
        $image=services_attachments::findOrfail($request->file_id);
        $service_name=services::where('id',$request->service_id)->pluck('name')->first();
        $image->delete();
        Storage::disk('services_uploads')->delete($service_name.'/'.$request->file_name);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }
}
