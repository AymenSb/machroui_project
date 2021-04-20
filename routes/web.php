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
Route::resource('attachment', FormationsAttachmentController::class);
Route::resource('machines',MachinesController::class);
Route::resource('rawmaterials',RawMaterialsController::class);
Route::resource('machinesrequests',RequestedMachinesController::class);
Route::resource('category',CategoryController::class);
Route::resource('subcategory',SubcategoryController::class);
Route::resource('addimage_machine',MachinesAttachmentsController::class);
Route::resource('updateimage_formation',FormationsAttachmentController::class);
Route::resource('addimage_material',RawmaterialsAttachmentsController::class);
Route::resource('ads',AdsController::class);
Route::resource('services',ServicesController::class);
Route::resource('add_image',ServicesAttachmentsController::class);


Route::get('getsubcategory/{id}',[CategoryController::class,'getsubcategory']);
Route::post('addToSub',[SubcategoryController::class,'addToSub'])->name('addToSub');
Route::get('editmachine/{machine_id}',[MachinesController::class,'editpage'])->name('editmachine');
Route::get('acceptMachine/{machine_id}',[RequestedMachinesController::class,'accept'])->name('accept');
Route::get('deleteMachine/{machine_id}',[RequestedMachinesController::class,'delete'])->name('deleteMachine');
Route::get('NewMachines',[MachinesController::class,'indexNew'])->name('new');
Route::get('UsedMachines',[MachinesController::class,'indexUsed'])->name('used');


Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

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