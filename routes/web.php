<?php

use App\Http\Controllers\CetakController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\WartaController;
use App\Http\Controllers\JemaatController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WilayahController;
use App\Http\Controllers\ImportExportController;


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

Auth::routes();


//Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('dasboardgereja');

//Jemaat
Route::get('/jemaat/ambilData/{data}', [JemaatController::class, 'getData']);
Route::post('/jemaat/datatabel', [JemaatController::class, 'dataTabel'])->name('jemaat.datatabel');
Route::post('/jemaat/import-data', [JemaatController::class, 'ImportData']);
Route::get('/download/baptis/{namaFile}', [JemaatController::class, 'getDownload'])->name('jemaat.baptis');
Route::resource('jemaat', JemaatController::class);

//Cetak
Route::get('/cetak', [CetakController::class, 'tampilViewCetak'])->name('cetak.viewCetak');
Route::get('/cetak/ambilDataFilter/{data}', [CetakController::class, 'getDataFilterCetak']);
Route::post('/cetak/printData', [CetakController::class, 'dataCetak'])->name('cetak.cetakData');
Route::get('/cetak/printJemaat/{data}', [CetakController::class, 'jemaatCetak'])->name('cetak.cetakJemaat');

//Warta
Route::get('/download/warta/{namaFile}', [WartaController::class, 'getDownloadWarta']);
Route::resource('warta', WartaController::class);

//Wilayah
Route::resource('wilayah', WilayahController::class);

//User
Route::get('/user/edituser/{data}', [UserController::class, 'edit'])->name('editUser');
Route::resource('user', UserController::class)->only([
    'index', 'store', 'edit', 'update', 'destroy'
]);;

//Import
Route::post('/import/import-user', [ImportExportController::class, 'ImportUserExcel']);
Route::get('/export/export-jemaat', [ImportExportController::class, 'ExportJemaatExcel']);
Route::post('/import/import-jemaat', [ImportExportController::class, 'ImportJemaatExcel']);
