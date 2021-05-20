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
    $this->middleware('permission:effacer service', ['only' => ['destroy']]);
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
            $service=services::latest()->first();
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Services Attachments/'.$request->name;
                $file_name =$files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                $base64Image=base64_encode(file_get_contents($destinationPath.'/'.$file_name));
                $file_extension=$files->getClientOriginalExtension();
                $image64Url="data:image/".$file_extension.";base64,".$base64Image;
                $data[]=$file_name;
                $allImages[]=$image64Url;                
            }
            $service->update([
                'images'=>$data,
                'base64Urls'=>$allImages,
            ]);
        }    

        
        else {
            $service=services::latest()->first();
            $service->update([
                'images'=>[],
                'base64Urls'=>[],
            ]);
        }
        session()->flash('ADD','le service a été créé');
        return redirect('/services');
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
        $images=services_attachments::where('service_id',$id)->first();
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
        if($service->images){
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
        $service=services::findOrfail($request->service_id);
        $service_name=$service->name;
        $data= $service->images;
        $base64Urls=$service->base64Urls;

        $destinationPath = 'Attachments/Services Attachments/'.$service_name.'/'.$request->file_name;
        $path_info=pathinfo($destinationPath);
        $file_extension=$path_info['extension'];
        $base64Image=base64_encode(file_get_contents($destinationPath));
        $image64Url="data:image/".$file_extension.";base64,".$base64Image;

        Storage::disk('services_uploads')->delete($service_name.'/'.$request->file_name);
        if (($key = array_search($request->file_name, $data)) !== false) {
            unset($data[$key]);
        }

        if(($key = array_search($image64Url,$base64Urls))!==false){
            unset($base64Urls[$key]);
        }
        $service->update([
            'images'=>array_values($data),
            'base64Urls'=>array_values($base64Urls),
            ]);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }
}
