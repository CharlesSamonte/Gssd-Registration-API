<?php

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/test-encryption', function () {
    $pathToFile = 'temp/rpmwo9slmfa3mo84rkkcxnkkydxptkr3/gssdlogo.png';
    $encryptedContents = Storage::get($pathToFile);

    return response()->json([
        'encryptedData' => $encryptedContents
    ]);
});

Route::get('/test-decryption', function () {
    try {
        $pathToFile = 'temp/rpmwo9slmfa3mo84rkkcxnkkydxptkr3/gssdlogo.png';

        // Get the encrypted file contents
        $encryptedContents = Storage::get($pathToFile);

        // Decrypt the contents correctly
        $decryptedContents = Crypt::decrypt($encryptedContents);

        // Return the decrypted file as a response (image preview)
        return response($decryptedContents)->header('Content-Type', 'image/png');

    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => $e->getMessage()
        ], 500);
    }
});

