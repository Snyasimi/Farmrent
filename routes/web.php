<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{AuthController,
        IncomeController,
        HomePageController,RentalController,
        EquipmentController};


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
Route::post('authenticate',[AuthController::class,'authenticate'])->name('authenticate');

Route::post('logout',[AuthController::class,'logout'])->name('logout');

Route::get('signup',[AuthController::class,'register'])->name('signUpPage');
Route::post('register',[AuthController::class,'signup'])->name('register');


//Route::get('/homepage',[HomePageController::class,'index'])->name('homepage');

Route::get('rentals/dashborad',[RentalController::class,'dashboard'])->name('homepage');
Route::get('equipment/available-equipment',[HomePageController::class,'listEquipment'])->name('rentEquipment');
Route::get('eqipment/search/',[EquipmentController::class,'queryEquipment'])->name('searchEquipment');

Route::get('rentals/requests',[RentalController::class,'rentalRequests'])->name('rentalRequests');
Route::get('rentals/leased',[RentalController::class,'leasedEquipment'])->name('leasedEquipment');
Route::patch('rentals/{rental}/update-status', [RentalController::class, 'updateStatus'])->name('rentals.updateStatus');

Route::resource('rentals', RentalController::class);
Route::resource('equipment',EquipmentController::class);
Route::resource('incomes',IncomeController::class);
Route::resource('equipment',EquipmentController::class);