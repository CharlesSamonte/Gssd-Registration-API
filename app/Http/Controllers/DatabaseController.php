<?php

namespace App\Http\Controllers;

use App\Services\DatabaseService;
use Illuminate\Http\Request;

class DatabaseController extends Controller
{
    public function index(Request $request, $tableName)
    {
        $dbService = new DatabaseService($tableName);
        return response()->json($dbService->getAll());
    }

}
