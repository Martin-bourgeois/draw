<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

Route::get('/', [UserController::class, 'showForm']);
Route::post('/submit', [UserController::class, 'store']);
Route::get('/users', [UserController::class, 'listUsers']);
Route::delete('/users/{id}', [UserController::class, 'deleteUser'])->name('user.delete');
