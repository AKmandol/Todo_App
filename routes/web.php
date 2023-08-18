<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoController;
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



Route::get('/get_all_task',[TodoController::class, 'getAll']);
Route::post('/add_task',[TodoController::class, 'addTask']);
Route::post('/delete_task',[TodoController::class, 'deleteTask']);
Route::post('/update_task',[TodoController::class, 'updateTask']);








Route::get('/{pathMatch}', function () {
    return view('welcome');
});
