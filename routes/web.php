<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;

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


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');


route::get('/redirect',[HomeController::class,'redirect']);

route::get('/',[HomeController::class,'index']);

route::get('/product',[AdminController::class,'product']);

route::post('/uploadproduct',[AdminController::class,'uploadproduct']);

route::get('/showproduct',[AdminController::class,'showproduct']);

route::get('/deleteproduct/{id}',[AdminController::class,'deleteproduct']);

route::get('/updateproduct/{id}',[AdminController::class,'updateproduct']);

route::post('/updateproductpost/{id}',[AdminController::class,'updateproductpost']);

route::post('/searchproduct',[AdminController::class,'searchproduct']);

route::get('/viewcustomer',[AdminController::class,'viewcustomer']);

route::post('/searchcustomer',[AdminController::class,'searchcustomer']);

route::get('/addadmin',[AdminController::class,'admin']);

route::post('/addadmin',[AdminController::class,'addadmin']);

route::get('/search',[HomeController::class,'search']);

route::post('/addcart/{id}',[HomeController::class,'addcart']);

route::get('/showcart',[HomeController::class,'showcart']);

route::get('/delete/{id}',[HomeController::class,'deletecart']);

route::post('/order',[HomeController::class,'confirm']);

route::get('/showorder',[AdminController::class,'showorder']);

route::get('/confirmorder/{id}',[AdminController::class,'confirmorder']);

route::get('/rejectorder/{id}',[AdminController::class,'rejectorder']);

route::get('/addcategory',[AdminController::class,'category']);

route::post('/addcategory',[AdminController::class,'addcategory']);
// send this id to the                  function