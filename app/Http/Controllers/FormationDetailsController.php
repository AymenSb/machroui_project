<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class FormationDetailsController extends Controller
{
    public function viewfile($formation_name,$file_name){
        $file=Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($formation_name.'/'.$file_name);
        return response()->file($file);
    }

    public function download($formation_name,$file_name){
        $file=Storage::disk('public_uploads')->getDriver()->getAdapter()->applyPathPrefix($formation_name.'/'.$file_name);
        return response()->download($file);
    }
}
