<?php

namespace App\Http\Controllers;

use App\Models\ads;
use App\Models\formations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class AdsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ads=ads::all();
        return view('ads/index',compact('ads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('ads/create');
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
            'name' => 'unique:ads|max:30',
        ],
        [
            'name.max'=>'Nom est trés long'
        ],
            [
                'name.unique'=>'Nom dejà utiliser',
            ]
        );
        
            $ads=new ads();
        $ads->name=$request->name;
        if($request->is_Visible=='Cachée'){
            $ads->is_Visible=0;
        }
        else{
            $ads->is_Visible=1;
        }

        if($request->hasFile('image')){
            $image=$request->file('image');
            $file_name=$image->getClientOriginalName();
            $ads->file_name=$file_name;
            $request->image->move(public_path('Attachments/Ads Attachments/'.$request->name ), $file_name);
        }
        $ads->save();

        session()->flash('ADD', 'Publicité ajoutée avec succès');
        return redirect('ads/create');
        

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function show(ads $ads)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $ad=ads::findOrfail($id);
        return view('ads/edit',compact('ad'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ads $ads)
    {
        $ads=ads::findOrfail($request->id);
        $old_name=$ads->name;

        if($request->is_Visible=='Cachée'){
            $value=0;
        }
        else {
            $value=1;
        }
        $ads->update([
            'name'=>$request->name,
            'is_Visible'=>$value,
        ]);

        $new_name=$ads->name;
        $image=$ads->file_name;
        if($old_name!=$new_name){
            Storage::disk('ads_uploads')->rename($old_name,$new_name);
        }
        session()->flash('edit','la publicité a été mise à jour');
        return back();
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ads  $ads
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ads=ads::findOrFail($request->ad_id);
        if(!empty($ads->name)){
            
            Storage::disk('ads_uploads')->deleteDirectory($ads->name);     
        }
        $ads->delete();
        return back();
    }

    public function viewfile_ad($ad_id,$file_name){
        $ad=ads::findOrfail($ad_id);
        $ad_name=$ad->name;
        $file=Storage::disk('ads_uploads')->getDriver()->getAdapter()->applyPathPrefix($ad_name.'/'.$file_name);
        return response()->file($file);
    }

    public function downloadAd($ad_id,$file_name){
        $ad=ads::findOrfail($ad_id);
        $ad_name=$ad->name;
        $file=Storage::disk('ads_uploads')->getDriver()->getAdapter()->applyPathPrefix($ad_name.'/'.$file_name);
        return response()->download($file);
    }

    public function updatePIC(Request $request){
        $image=$request->File('file_name');
         $new_file=$image->getClientOriginalName();
         $ad=ads::findOrfail($request->id);
         $old_file=$ad->file_name;
         $ad->update([
            'file_name'=>$new_file,
         ]);
         if(!empty($old_file)){
            Storage::disk('ads_uploads')->delete($ad->name.'/'.$old_file);
        }
        $request->file_name->move(public_path('Attachments/Ads Attachments/' .$ad->name ), $new_file);
        session()->flash('file',"l'image a été modifiée");
        return back();
    }
}
