<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    /**
     * Generic function to retrieve data from a table.
     *
     * @param Request $request
     * @param string $tableName
     * @return JsonResponse
     */

    public function getTableData(Request $request, string $tableName): JsonResponse
    {
        try {

            // Validate the table name to prevent SQL injection
            if (!preg_match('/^[a-zA-Z0-9_]+$/', $tableName)) {
                return response()->json(['error' => 'Invalid table name'], 400);
            }
            // Check if the table exists in the database
            if (!DB::connection('sqlsrv')->getSchemaBuilder()->hasTable($tableName)) {
                return response()->json(['error' => 'Table not found'], 404);
            }

            // Optional filters from the request
            $filters = $request->all();

            $query = DB::connection('sqlsrv')->table($tableName);

            foreach ($filters as $column => $value) {
                $query->where($column, $value);
            }

            // Execute the query and get results
            $data = $query->get();

            return response()->json($data, 200);
        } catch (\Exception $e) {
            // Log the error for debugging
            \Log::error("Error fetching data from table {$tableName}: " . $e->getMessage());

            // Return a JSON response with the error message
            return response()->json([
                'error' => 'Failed to retrieve data from the table.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}