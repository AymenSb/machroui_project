<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\FormationsAttachmentController;
use App\Http\Controllers\FormationDetailsController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\RequestedMachinesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\RawMaterialsController;
use App\Http\Controllers\MachinesAttachmentsController;
use App\Http\Controllers\RawmaterialsAttachmentsController;
use App\Http\Controllers\AdsController;
use App\Http\Controllers\ServicesController;
use App\Http\Controllers\ServicesAttachmentsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectAttachmentsController;
use App\Http\Controllers\FormationsRequestsController;
use App\Http\Controllers\MachinesOffersController;
use App\Http\Controllers\RawmaterialsRequestsController;



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('home');
});


Route::resource('formations', FormationsController::class);
Route::resource('formations-requests', FormationsRequestsController::class);
Route::resource('attachment', FormationsAttachmentController::class);
Route::resource('machines',MachinesController::class);
Route::resource('machines-offers',MachinesOffersController::class);
Route::resource('rawmaterials',RawMaterialsController::class);
Route::resource('rawmaterials-requests',RawmaterialsRequestsController::class);
Route::resource('machinesrequests',RequestedMachinesController::class);
Route::resource('category',CategoryController::class);
Route::resource('subcategory',SubcategoryController::class);
Route::resource('addimage_machine',MachinesAttachmentsController::class);
Route::resource('updateimage_formation',FormationsAttachmentController::class);
Route::resource('addimage_material',RawmaterialsAttachmentsController::class);
Route::resource('addimage_project',ProjectAttachmentsController::class);
Route::resource('ads',AdsController::class);
Route::resource('services',ServicesController::class);
Route::resource('add_image',ServicesAttachmentsController::class);
Route::resource('project',ProjectController::class);

Route::get('getsubcategory/{id}',[CategoryController::class,'getsubcategory']);
Route::post('editCategory',[CategoryController::class,'editCategory'])->name('editCategory');
Route::post('deleteCategory',[CategoryController::class,'deleteCategory'])->name('deleteCategory');
Route::post('addToSub',[SubcategoryController::class,'addToSub'])->name('addToSub');
Route::post('updateSubCategory',[SubcategoryController::class,'updateSubCategory'])->name('updateSubCategory');
Route::post('DeleteSubCategory',[SubcategoryController::class,'DeleteSubCategory'])->name('DeleteSubCategory');
Route::get('acceptMachine/{machine_id}',[RequestedMachinesController::class,'accept'])->name('accept')->middleware('permission:accept machine');
Route::get('deleteMachine/{machine_id}',[RequestedMachinesController::class,'delete'])->name('deleteMachine')->middleware('permission:rejeter machine');;
Route::get('NewMachines',[MachinesController::class,'indexNew'])->name('new')->middleware('permission:nouvelles machines');
Route::get('UsedMachines',[MachinesController::class,'indexUsed'])->name('used')->middleware('permission:machines occasions');

// Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes(['register' => false]);

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home')->middleware('permission:accès au tableau de bord');
Route::group(['middleware' => 'auth'], function () {
    Route::resource('roles',RoleController::class);
    Route::resource('users',UserController::class);
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);

});

Route::get('viewfile/{formation_id}/{file_id}',[FormationDetailsController::class,'viewfile'])->name('ViewFormation');
Route::get('download/{formation_id}/{file_id}',[FormationDetailsController::class,'download'])->name('downloadFormation');

Route::get('viewfile_machines/{machine_id}/{file_id}',[MachinesController::class,'viewfile']);
Route::get('download_machines/{machine_id}/{file_id}',[MachinesController::class,'download']);
Route::post('deletefile_machine',[MachinesController::class,'deletefile'])->name('deletefile_machine');

Route::get('viewfile_material/{machine_id}/{file_id}',[RawMaterialsController::class,'viewfile_material']);
Route::get('download_material/{machine_id}/{file_id}',[RawMaterialsController::class,'downloadMaterial']);
Route::post('deletefile_material',[RawMaterialsController::class,'deletefile_material'])->name('DFMaterials');

Route::get('viewfile_ad/{ad_id}/{file_name}',[AdsController::class,'viewfile_ad'])->name('viewfile_ad');
Route::get('downloadAd/{ad_id}/{file_name}',[AdsController::class,'downloadAd'])->name('downloadAd');       
Route::post('updatePIC/{ad_id}',[AdsController::class,'updatePIC'])->name('updatePIC');  

Route::get('viewfile_service/{service_id}/{file_id}',[ServicesController::class,'viewfile_service'])->name('viewfile_service');
Route::get('download_service/{service_id}/{file_id}',[ServicesController::class,'download_service'])->name('download_service');
Route::post('deletefile_service',[ServicesController::class,'deletefile_service'])->name('deletefile_service');


Route::get('viewfile_project/{id}/{file_id}',[ProjectController::class,'viewfile_project'])->name('viewfile_project');
Route::get('download_project/{id}/{file_id}',[ProjectController::class,'download_project'])->name('download_project');
Route::post('deletefile_project',[ProjectController::class,'deletefile_project'])->name('deletefile_project');

Route::post('sendToVendor/{id}',[MachinesOffersController::class,'sendToVendor'])->name('sendToVendor');

