<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\apis_controller;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FormationsRequestsController;
use App\Http\Controllers\MachinesOffersController;
use App\Http\Controllers\RawmaterialsRequestsController;
use App\Http\Controllers\ServicesController;


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
Route::get('/api_formationsCat/{id}',[FormationsController::class,'getFormationsCat']);
Route::get('/api_formations/{id}',[FormationsController::class,'getFormationById']);
Route::get('/getAllCatFormations/{id}',[FormationsController::class,'getAllCatFormations']);
Route::get('subcategoriesformations/{id}',[FormationsController::class,'getsubcategoriesFormations']);

Route::get('/api_machines',[MachinesController::class,'getMachines']);
Route::get('/api_machinesCat/{id}',[MachinesController::class,'getMachinesCat']);
Route::get('/api_machines/{id}',[MachinesController::class,'getMachineById']);
Route::get('subcategoriesmachine/{id}',[MachinesController::class,'MachineSubCategories']);
Route::get('categoriesMachines/{id}',[MachinesController::class,'getAllCategoriesForMachines']);


Route::get('/api_materials',[RawMaterialsController::class,'getMaterials']);
Route::get('/api_materialsCat/{id}',[RawMaterialsController::class,'getMaterialsCat']);
Route::get('/api_materials/{id}',[RawMaterialsController::class,'getMaterialById']);
Route::get('/subcategoriesmaterials/{id}',[RawMaterialsController::class,'getSubCategoriesRawMaterials']);
Route::get('/categoriesMaterials/{id}',[RawMaterialsController::class,'getAllCategoriesForMaterials']);


Route::get('/api_categories',[CategoryController::class,'getCategories']);

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::post('/user-update-info/{id}',[UserController::class,'updateUserInfo']);  

//client requests APIs

Route::post('/demandeRawMaterial',[RawmaterialsRequestsController::class,'demandeRawMaterials']);


Route::post('/FormationsRequests',[FormationsRequestsController::class,'formationsRequests']); 
Route::get('/ClientFormations/{client_id}',[FormationsRequestsController::class,'ClientFormations']);
Route::post('/ClientConfirmedFormation',[FormationsRequestsController::class,'ClientConfirmed']);
Route::post('/ClientDeclinedFormation',[FormationsRequestsController::class,'ClientDeclined']);

Route::post('/machinesOffer',[MachinesOffersController::class,'machinesOffers']); 


Route::post('/postMachine',[MachinesController::class,'postMachines']); 

Route::get('/vendorMachines/{id}',[MachinesController::class,'vendorMachines']);
Route::get('VendorOffers/{machine_id}',[MachinesOffersController::class,'vendorOffers']);
Route::post('acceptOffer',[MachinesOffersController::class,'acceptOffer']);
Route::post('deleteOffer',[MachinesOffersController::class,'deleteOffer']);


Route::get('search-results',[MachinesController::class,'searchingForMachines']);

Route::get('services',[ServicesController::class,'getServices']);