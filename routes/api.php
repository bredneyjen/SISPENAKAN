<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\PengajuanDonasiController;
use App\Http\Controllers\UserDonasiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use PharIo\Manifest\Author;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// Route::post('/donasiUser',UserDonasiController::class,'storeUserDonasi');

Route::post('/pengajuan-donasi',[UserDonasiController::class,'storeUserDonasi']);
Route::get('/getDataUser',[UserDonasiController::class,'getDataUser']);
Route::put('/putDataUser/{id}',[UserDonasiController::class,'update']);
Route::put('/putDataDonasi/{id}',[UserDonasiController::class,'updateDonasi']);
Route::delete('/deleteDataUser/{id}',[UserDonasiController::class,'destroy']);

Route::get('/get-permohonan-donasi',[PengajuanDonasiController::class,'index']);
Route::post('/post-permohonan-donasi',[PengajuanDonasiController::class,'store']);
Route::put('/put-permohonan-donasi/{id}',[PengajuanDonasiController::class,'update']);
Route::delete('/delete-permohonan-donasi/{id}',[PengajuanDonasiController::class,'destroy']);
Route::post('/status-pengajuan/{id}/{status}',[PengajuanDonasiController::class,'statusPengajuan']);

Route::post('/login',[AuthController::class,'auth']);
Route::post('/logout',[AuthController::class,'logout']);
Route::post('/register',[AuthController::class,'register']);

Route::post('/status-laporan/{id}/{status}',[UserDonasiController::class,'statusPengajuan']);
Route::get('/getDataLaporan',[LaporanController::class,'index']);
Route::get('/getDataLaporan/{id}',[UserDonasiController::class,'getDataLaporanID']);
Route::get('/User',[LaporanController::class,'user']);
Route::post('/User/{id}',[LaporanController::class,'update']);
Route::post('/upload-bukti/{id}', [LaporanController::class,'uploadBukti']);

Route::get('data/{id}/edit', [PengajuanDonasiController::class,'edit']);
Route::put('data/{id}/edit', [PengajuanDonasiController::class,'update']);



