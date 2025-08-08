<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController,HomePageController};


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login',[AuthController::class,'login'])->name('login');

Route::get('signup',[AuthController::class,'register'])->name('signUpPage');

Route::get('/homepage',[HomePageController::class,'index'])->name('homepage');