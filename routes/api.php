<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DatabaseController;
use App\Http\Controllers\AccessCodeController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\FileUploadController;

Route::middleware('throttle:30,60')->get('/db/{table}', [DatabaseController::class, 'index']);

Route::post('/upload-temp-file', [FileUploadController::class, 'upload'])->middleware('throttle:10,1');
Route::post('/delete-temp-file', [FileUploadController::class, 'delete'])->middleware('throttle:10,1');

Route::post('/generate-access-code', [AccessCodeController::class, 'generate'])->middleware('throttle:3,1');
Route::post('/validate-access-code', [AccessCodeController::class, 'validateCode'])->middleware('throttle:access-code');

Route::post('/submit-registration', [RegistrationController::class, 'store'])->middleware('throttle:2,10');

