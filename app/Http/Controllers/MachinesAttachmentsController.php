<?php

namespace App\Http\Controllers;

use App\Models\MachinesAttachments;
use App\Models\machines;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class MachinesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
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
        if ($request->hasFile('file_name')) {
            $machine_name=$request->machine_name;
            $machine_id=$request->machine_id;
            $machine=machines::findOrFail($machine_id);
            $old_data=$machine->images;
            $old_base64Urls=$machine->base64Urls;
            $image = $request->file('file_name');


            foreach($image as $files){
            $destinationPath = 'Attachments/Machines Attachments/'.$machine_name;
            $file_name =$files->getClientOriginalName();
            $file_extension=$files->getClientOriginalExtension();
            $files->move($destinationPath, $file_name);
            $base64Image=base64_encode(file_get_contents('Attachments/Machines Attachments/'.$machine_name.'/'.$file_name));
            $image64Url="data:image/".$file_extension.";base64,".$base64Image;
            $data[]=$file_name;
            $base64Urls[]=$image64Url;
            }


            $new_data=array_unique(array_merge($data,$old_data),SORT_REGULAR);
            $new_base64Urls=array_unique(array_merge($base64Urls,$old_base64Urls),SORT_REGULAR);

            $machine->update([
                'images'=>$new_data,
                'base64Urls'=>$new_base64Urls,
                'main_image'=>$new_base64Urls[0],
            ]);
            
            session()->flash('created',"L'image a été créée");
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function show(MachinesAttachments $machinesAttachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function edit(MachinesAttachments $machinesAttachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, MachinesAttachments $machinesAttachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MachinesAttachments  $machinesAttachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(MachinesAttachments $machinesAttachments)
    {
        //
    }

    public function ViewVideo($machine_name,$video_name){
        if(Storage::disk('machines_uploads')->getDriver()->getAdapter()->has($machine_name . '/Video/'. $video_name)){
            $file = Storage::disk('machines_uploads')->getDriver()->getAdapter()->applyPathPrefix($machine_name . '/Video/'. $video_name);
            return response()->file($file);
        }
        else {
            return abort(404);
        }
    }
    public function DownloadVideo($machine_name,$video_name){
        if(Storage::disk('machines_uploads')->getDriver()->getAdapter()->has($machine_name . '/Video/'. $video_name)){
            $file = Storage::disk('machines_uploads')->getDriver()->getAdapter()->applyPathPrefix($machine_name . '/Video/'. $video_name);
            return response()->download($file);
        }
        else {
            return abort(404);
        }
    }
    public function ChangeVideo(Request $request){
        if($request->hasFile('video')){
            $machine_name=$request->machine_name;
            $machine_id=$request->machine_id;
            $machine=machines::findOrFail($machine_id);
            $old_video=$machine->video_name;
            $video = $request->file('video');
            
            if(!empty($old_video)){
                Storage::disk('machines_uploads')->delete($machine_name.'/Video/'.$old_video);
            }
            
            $destinationPath = 'Attachments/Machines Attachments/'.$machine_name.'/Video';
            $file_name =$video->getClientOriginalName();
            $file_extension=$video->getClientOriginalExtension();
            $video->move($destinationPath, $file_name);
            $base64Video=base64_encode(file_get_contents('Attachments/Machines Attachments/'.$machine_name.'/Video/'.$file_name));
            $videoUrl="data:video/".$file_extension.";base64,".$base64Video;
            
            $machine->update([
                'video_name'=>$file_name,
                'video_base64'=>$videoUrl
            ]);

            session()->flash('created',"Video à été modifer");
            return back();
        }
    }
   
}
