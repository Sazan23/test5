<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UploadController;
use App\Http\Controllers\DownloadController;
use App\Http\Controllers\AjaxController;
use Illuminate\Support\Facades\Artisan;

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
Route::get('/list/{file_id}', [MainController::class, 'records']);
Route::get('/download/xls/{id}', [DownloadController::class, 'downloadXLS']);
Route::get('/download/pdf/full/{file_id}', [DownloadController::class, 'downloadPDF_fullReport'])->middleware('tcpdf');
Route::get('/download/pdf/single/{file_id}/{id}', [DownloadController::class, 'downloadPDF_record'])->middleware('tcpdf');
Route::post('/upload', [UploadController::class, 'upload']);
Route::post('/update', [AjaxController::class, 'updateItem'])->name('itemSave');
Route::post('/delete', [AjaxController::class, 'deleteItem'])->name('itemDelete');
Route::post('/upload_img', [AjaxController::class, 'uploadImg'])->name('uploadImg');

Route::get('/linkstorage', function () {
    Artisan::call('storage:link');
});