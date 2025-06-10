<?php
namespace App\Http\Controllers;

use App\Services\FileUploadService;
use Illuminate\Http\Request;
use RequestParseBodyException;

class FileUploadController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function upload(Request $request)
    {

        if (!$request->hasFile('file')) {
            return response()->json(['error' => 'No file uploaded.'], 400);
        }

        $data = [
            'file' => $request->file('file'),
            'folderID' => $request->input('fileUploadID')
        ];

        \Log::info('File received:', $data); // or use dd($request->all());

        $filePath = $this->fileUploadService->uploadTemporaryFile($data);

        return response()->json([
            'message' => 'File uploaded successfully',
            'path' => $filePath
        ]);
    }

    public function delete(Request $request)
    {
        $data = [
            'fileName' => $request->input('fileName'),
            'folderID' => $request->input('fileUploadID')
        ];

        $filePath = $this->fileUploadService->deleteTemporaryFile($data);

        return response()->json([
            'message' => 'File deleted successfully',
            'path' => $filePath
        ]);
    }
}