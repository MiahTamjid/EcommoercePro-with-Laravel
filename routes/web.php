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

/* Route::get('/', function () {
    return view('welcome');
});
 */
Route::get('/',[HomeController::class,'index']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::get('/redirect',[HomeController::class,'redirect'])->middleware('auth','verified');//admin
Route::get('/product_details/{id}',[HomeController::class,'product_details']);
Route::post('/add_card/{id}',[HomeController::class,'add_card']);
Route::get('/show_cart',[HomeController::class,'show_cart']);
Route::get('/show_order',[HomeController::class,'show_order']);
Route::get('/remove_card/{id}',[HomeController::class,'remove_card']);
Route::get('/cash_order',[HomeController::class,'cash_order']);
Route::get('/stripe/{totalprice}',[HomeController::class,'stripe']);
Route::post('stripe/{totalprice}',[HomeController::class,'stripePost'])->name('stripe.post');
Route::get('/cancel_order/{id}',[HomeController::class,'cancel_order']);


Route::get('/view_catagory',[AdminController::class,'view_catagory']);
Route::post('/add_catagory',[AdminController::class,'add_catagory']);
Route::get('/delete_catagory/{id}',[AdminController::class,'delete_catagory']);
Route::get('/view_product',[AdminController::class,'view_product']);
Route::post('/add_product',[AdminController::class,'add_product']);
Route::get('/show_product',[AdminController::class,'show_product']);
Route::get('/delete_product/{id}',[AdminController::class,'delete_product']);
Route::get('/edit_product/{id}',[AdminController::class,'edit_product']);
Route::post('/edit_product_confirm/{id}',[AdminController::class,'edit_product_confirm']);
Route::get('/order',[AdminController::class,'order']);
Route::get('/delivered/{id}',[AdminController::class,'delivered']);
Route::get('/print_pdf/{id}',[AdminController::class,'print_pdf']);
Route::get('/sent_email/{id}',[AdminController::class,'sent_email']);
Route::post('/sent_user_email/{id}',[AdminController::class,'sent_user_email']);
Route::get('/search',[AdminController::class,'search']);


