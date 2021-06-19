<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\subcategory;
use App\Models\machines;
use App\Models\machines_offers;
use App\Models\MachinesAttachments;
use App\Models\RequestedMachines;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class MachinesController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:machine|toutes les machine|requetes des machines en attend|nouvelles machines|machines occasions|crée machine|modifier machine|effacer machine|accept machine|rejeter machine', ['only' => ['index', 'show']]);
        $this->middleware('permission:crée machine', ['only' => ['create', 'store']]);
        $this->middleware('permission:modifier machine', ['only' => ['edit', 'update']]);
        $this->middleware('permission:effacer machine', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {$categories = Category::all();
        $machines = machines::all();
        return view('machines/machines/index', compact('machines', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {$categories = Category::all();
        return view('machines/machines/create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->state == 'Nouvelle machine') {
            $statVal = 2;
        } else {
            $statVal = 1;
        }
        machines::create([
            'name' => $request->name,
            'price' => $request->price,
            'details' => $request->details,
            'characteristics' => $request->characteristics,
            'markDetails' => $request->markDetails,
            'state' => $request->state,
            'stateVal' => $statVal,

        ]);
        if ($request->hasFile('image')) {
            $machine = machines::latest()->first();
            $image = $request->file('image');
            foreach ($image as $files) {
                $destinationPath = 'Attachments/Machines Attachments/' . $request->name;
                $file_name = $files->getClientOriginalName();
                $files->move($destinationPath, $file_name);
                
                $base64Image=base64_encode(file_get_contents($destinationPath.'/'.$file_name));
                $file_extension=$files->getClientOriginalExtension();
                $image64Url="data:image/".$file_extension.";base64,".$base64Image;
                $data[]=$file_name;
                $allImages[]=$image64Url;
                
            }
            $machine->update([
                'images'=>$data,
                'base64Urls'=>$allImages,
                'main_image'=>$allImages[0],
            ]);
           
        }


        else{
            $machine = machines::latest()->first();
            $machine->update([
               'images'=>[],
               'base64Urls'=>[],
           ]);
        }

        if($request->category){
            if($request->subcategory){
              $subcategory=subcategory::where('id',$request->subcategory)->first();
              $machine=machines::latest()->first();
              $subcategory->machines()->syncWithoutDetaching($machine);
            }
        }

        session()->flash('add', 'La machine a été ajoutée avec succès');
        return redirect('/machines');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $machine = machines::findOrFail($id);
        $offers=machines_offers::where('machine_id',$id)->where('Accpted',1)->get();
        return view('machines/machines/show', compact('machine','offers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {   $categories=Category::all();
        $machine = machines::findOrfail($id);
        return view('machines/machines/edit', compact('machine','categories'));
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
        $id = $request->id;
        $machine = machines::findOrFail($id);
        $images = MachinesAttachments::where('machine_id', $id)->get();
        $old_name = $machine->name;
        $machine->update([
            'name' => $request->name,
            'price' => $request->price,
            'Vendor' => $request->Vendor,
            'details' => $request->details,
            'characteristics' => $request->characteristics,
            'markDetails' => $request->markDetails,
            'state' => $request->state,
            'stateVal' => $request->stateVal,
        ]);
        $new_name = $machine->name;
        if (!empty($images)) {
            if(Storage::disk('machines_uploads')->files($old_name)){
                if($old_name!=$new_name)
            Storage::disk('machines_uploads')->rename($old_name, $new_name);}
        }
        $stateVal_new = 2;
        $stateVal_used = 1;
        if ($request->state == 'Nouvelle machine') {
            $machine->update([
                'stateVal' => $stateVal_new,
            ]);

        } else {
            $stateVal = 1;
            $machine->update([
                'stateVal' => $stateVal_used,
            ]);
        }

        
        if($request->category){
            if($request->subcategory){
            $subcategory=subcategory::where('id',$request->subcategory)->first();
             $machine=machines::where('id',$request->id)->first();
             $subcategory->machines()->sync($machine);
            }
        }
        session()->flash('updated', "la machine a été mise à jour");
        return redirect('/machines');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\machines  $machines
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $machine = machines::findOrFail($request->machine_id);
        if ($machine->images) {
            Storage::disk('machines_uploads')->deleteDirectory($machine->name);

        }
        $machine->delete();
        session()->flash('delete', 'machine has been deleted');
        return redirect('/machines');
    }

    public function indexNew()
    {
        $Newmachines = machines::where('stateVal', 2)->get();
        return view('machines/machines/indexNew', compact('Newmachines'));
    }

    public function indexUsed()
    {
        $Usedmachines = machines::where('stateVal', 1)->get();
        return view('machines/machines/indexUsed', compact('Usedmachines'));
    }

    public function delete($id)
    {
        $machine = machines::findOrFail($id);
        $machine->delete();
        return back();
    }

    public function viewfile($formation_name, $file_name)
    {

        $file = Storage::disk('machines_uploads')->getDriver()->getAdapter()->applyPathPrefix($formation_name . '/' . $file_name);
        return response()->file($file);
    }

    public function download($formation_name, $file_name)
    {
        $file = Storage::disk('machines_uploads')->getDriver()->getAdapter()->applyPathPrefix($formation_name . '/' . $file_name);
        return response()->download($file);
    }

    public function deletefile(Request $request)
    {
        $machine = machines::findOrfail($request->file_id);
        $machine_name = machines::where('id', $request->machine_id)->pluck('name')->first();
        $images= $machine->images;
        $Base64Urls=$machine->base64Urls;
        $base64Image=base64_encode(file_get_contents('Attachments/Machines Attachments/'.$machine_name.'/'.$request->file_name));
        $pathInfo=pathinfo(public_path('Attachments/Machines Attachments/'.$machine_name.'/'.$request->file_name,PATHINFO_EXTENSION));
        $file_extension=$pathInfo['extension'];
        $image64Url="data:image/".$file_extension.";base64,".$base64Image;

     
         if (($key = array_search($request->file_name, $images)) !== false) {
             unset($images[$key]);
         }

            if(($key = array_search($image64Url,$Base64Urls))!==false){
                unset($Base64Urls[$key]);
            }

            if($Base64Urls){
                $machine->update([
                    'images'=>array_values($images),
                    'base64Urls'=>array_values($Base64Urls),
                    'main_image'=>$Base64Urls[1],
                ]);
            }

            else{
                $machine->update([
                    'images'=>array_values($images),
                    'base64Urls'=>array_values($Base64Urls),
                    'main_image'=>''
                ]);
            }
       
    Storage::disk('machines_uploads')->delete($machine_name . '/' . $request->file_name);
        session()->flash('delete','La photo a été supprimée');
        return back();
    }


    function getMachines(){
        $machines=machines::all();
        return response()->json($machines);
    }

    function getMachineById($id){
        $machine=machines::where('id',$id)->first();
        return $machine;
    }
    function MachineSubCategories($id){
        $machine=machines::where('id',$id)->first();
        if($machine!=null){
            $subcategories=$machine->subcategory()->select('name','subcategory_id')->get();
            return $subcategories;
        }
        else {
            return response()->json('Empty');
        }
    }

    function getMachinesCat($id){
        $machines=machines::
                    join('machines_subcategory','machines.id','machines_subcategory.machines_id')
                    ->where('machines_subcategory.subcategory_id',$id)
                    ->select('machines.*')
                    ->get();
      return $machines;
    }

    function postMachines(Request $request){
        if($request->state=='new'){
            $etat='Nouvelle machine';
            $stateVal=2;
        }
        else {
            $etat="Machine d'occasion";
            $stateVal=1;
        }
       
        RequestedMachines::create([
            'name'=>$request->name,
            'price'=>$request->price,
            'Vendor'=>$request->vendor,
            'vendor_id'=>$request->vendor_id,
            'markDetails'=>$request->brand,
            'details'=>$request->details,
            'characteristics'=>$request->characteristics,
            'state'=>$etat,
            'stateVal'=>$stateVal,
            'main_image'=>$request->main_image,
            'base64Urls'=>$request->base64Urls,
            'images'=>$request->images,
           
        ]);
        $index=0;

        foreach($request->base64Urls as $file_data){
            
            $file_name = $request->images[$index]; //generating unique file name; 
            @list($type, $file_data) = explode(';', $file_data);
            @list(, $file_data) = explode(',', $file_data); 
            if($file_data!="")
                {
                Storage::disk('machines_uploads')->put($request->name. '/' .$file_name,base64_decode($file_data)); 
                
            } 
            $index++;
        }
       


            return response()->json(
                "Votre machine est postuler"
            );
    }

    function vendorMachines($id){
        $vendor_machines=machines::where('vendor_id',$id)->get();
        return $vendor_machines;
    }
}
