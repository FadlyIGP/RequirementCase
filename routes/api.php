<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// $router->post('user/register', 'UserController@register');
Route::post('/user/register', [App\Http\Controllers\UserController::class, 'register'])->name('register');
Route::post('/user/login', [App\Http\Controllers\UserController::class, 'login'])->name('register');
// Crud Profile
Route::post('/profile/create', [App\Http\Controllers\ProfilController::class, 'Create'])->name('Create');
Route::get('/profile/listprofil', [App\Http\Controllers\ProfilController::class, 'ListProfil'])->name('ListProfil');
Route::post('/profile/update', [App\Http\Controllers\ProfilController::class, 'Update'])->name('Update');
Route::post('/profile/delete', [App\Http\Controllers\ProfilController::class, 'Delete'])->name('Delete');






