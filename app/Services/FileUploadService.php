<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    private function renameFile($fileName)
    {
        return "temp_" . $fileName;
    }

    public function uploadTemporaryFile($data)
    {
        if (!$data) {
            throw new \Exception('No data provided.');
        }

        $file = $data['file'];
        $folderID = $data['folderID'];
        $origFileName = $file->getClientOriginalName();

        $fileName = $this->renameFile($origFileName);

        $pathToFile = $folderID . '/' . $fileName;

        // Store file in the temp directory
        return $file->storeAs('temp/' . $pathToFile);
    }

    public function deleteTemporaryFile($data)
    {
        $originalFileName = $data["fileName"];
        $folderID = $data['folderID'];

        $formattedFileName = $this->renameFile($originalFileName);

        $filePath = 'temp/' . $folderID . "/" . $formattedFileName;

        if (Storage::exists($filePath)) {
            Storage::delete($filePath);
            return response()->json(['message' => 'File deleted successfully']);
        } else {
            return response()->json(['error' => 'File not found'], 404);
        }


    }
}