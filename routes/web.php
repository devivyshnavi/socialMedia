<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
//Google login
Route::get('login/google', [LoginController::class, 'redirectToGoogle'])->name('login.google');
Route::get('login/google/callback', [LoginController::class, 'handleGoogleCallback']);

//Github login
Route::get('login/github', [LoginController::class, 'redirectToGithub'])->name('login.github');
Route::get('login/github/callback', [LoginController::class, 'handleGithubCallback']);

//edit
Route::get('edit/{id}', [userController::class, 'edit']);
Route::put('update/{id}', [userController::class, 'update']);
Route::get('changepassword/{id}', [userController::class, 'changepassword']);
Route::put('updatepassword/{id}', [userController::class, 'updatepassword']);
//logout
Route::get('logout', [LoginController::class, 'logout']);
