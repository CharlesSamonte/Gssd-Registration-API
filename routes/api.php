<?php

use App\Http\Controllers\DatabaseController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FileUploadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/



Route::get('/db/{table}', [DatabaseController::class, 'index']);
Route::put('/db/{table}/{id}', [DatabaseController::class, 'update']);

Route::post('/upload-temp-file', [FileUploadController::class, 'upload']);
Route::post('/delete-temp-file', [FileUploadController::class, 'delete']);

Route::post('/generate-access-code', [AccessCodeController::class, 'generate']);
Route::post('/validate-access-code', [AccessCodeController::class, 'validateCode']);

Route::post('/submit-registration', [RegistrationController::class, 'store']);
