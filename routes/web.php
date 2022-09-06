<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\AjaxController;

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
})->name('home');

Route::get('/list', [MainController::class, 'list'])->name('list');
Route::get('/list/{id}', [MainController::class, 'records']);
Route::post('/upload', [UploadController::class, 'upload']);
Route::post('/update', [AjaxController::class, 'updateItem'])->name('itemSave');
Route::post('/delete', [AjaxController::class, 'deleteItem'])->name('itemDelete');

Route::get('/xdebug', function () {
    return view('xdebug');
});

Route::get('/dp', function () {
    return view('dp');
});