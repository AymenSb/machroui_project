<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClientNotifications;
use Illuminate\Support\Facades\DB;


class apis_controller extends Controller
{
    function ClientNotifications($client_id){
        $_count=ClientNotifications::where('client_id',$client_id)
                                    ->where('new',1)
                                    ->count();
        $notifications=ClientNotifications::where('client_id',$client_id)->get();
        
        return response()->json([
            "count"=>$_count,
            "notifications"=>$notifications
        ]);
    }
}
