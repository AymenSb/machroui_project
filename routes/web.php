<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FormationsController;
use App\Http\Controllers\FormationsAttachmentController;
use App\Http\Controllers\FormationDetailsController;
use App\Http\Controllers\MachinesController;
use App\Http\Controllers\RequestedMachinesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;


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
Route::resource('machinesrequests',RequestedMachinesController::class);
Route::resource('category',CategoryController::class);
Route::resource('subcategory',SubcategoryController::class);

Route::get('getsubcategory/{id}',[CategoryController::class,'getsubcategory']);
Route::post('addToSub',[SubcategoryController::class,'addToSub'])->name('addToSub');
Route::get('deletethemachine/{machine_id}',[MachinesController::class,'delete'])->name('deletethemachine');
Route::get('editmachine/{machine_id}',[MachinesController::class,'editpage'])->name('editmachine');
Route::get('acceptMachine/{machine_id}',[RequestedMachinesController::class,'accept'])->name('accept');
Route::get('deleteMachine/{machine_id}',[RequestedMachinesController::class,'delete'])->name('deleteMachine');
Route::get('NewMachines',[MachinesController::class,'indexNew'])->name('new');
Route::get('UsedMachines',[MachinesController::class,'indexUsed'])->name('used');

Auth::routes(['register' => false]);

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Auth::routes();

Route::get('/', 'App\Http\Controllers\HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'App\Http\Controllers\PageController@index']);
});

Route::get('viewfile/{formation_id}/{file_id}',[FormationDetailsController::class,'viewfile']);
Route::get('download/{formation_id}/{file_id}',[FormationDetailsController::class,'download']);

