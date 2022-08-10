<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

//Register
Route::get('/register', [PageController::class, 'register'])->name('register.show');
Route::post('/register', [LoginController::class, 'register'])->name('register');

//Login
Route::get('/login', [PageController::class, 'login'])->name('login.show');
Route::post('/login', [LoginController::class, 'login'])->name('login');

//Logged in user session middleware
Route::middleware('user.session')->group(function() {

    //Dashboard
    Route::get('/', [PageController::class, 'home'])->name('home');

    //Logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

});
