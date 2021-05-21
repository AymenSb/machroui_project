<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\apis_controller;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/latests',[apis_controller::class,'latests']);


Route::get('/api_projects',[ProjectController::class,'getAllProjects']);
Route::get('/api_projects/{id}',[ProjectController::class,'getProjectById']);


Route::get('/api_formations',[FormationsController::class,'getFormations']);
Route::get('/api_formations/{id}',[FormationsController::class,'getFormationById']);


Route::get('/api_machines',[MachinesController::class,'getMachines']);
Route::get('/api_machines/{id}',[MachinesController::class,'getMachineById']);


Route::get('/api_materials',[RawMaterialsController::class,'getMaterials']);
Route::get('/api_materials/{id}',[RawMaterialsController::class,'getMaterialById']);

