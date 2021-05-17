<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class apis_controller extends Controller
{
    function latests(){
        $project=DB::table('projects')->latest()->first();
        $machine=DB::table('machines')->latest()->first();
        $formation=DB::table('projects')->latest()->first();
        $raw_mat=DB::table('projects')->latest()->first();
        
        $test=array($machine);
        $test2=array($project);
        $tesss=array_merge($test,$test2);
       
        return response()->json($tesss);
        
    }
}
