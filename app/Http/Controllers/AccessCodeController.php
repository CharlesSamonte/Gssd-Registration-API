<?php
namespace App\Http\Controllers;

use App\Services\AccessCodeService;
use Illuminate\Http\Request;

class AccessCodeController extends Controller
{
    protected $accessCodeService;

    public function __construct(AccessCodeService $accessCodeService)
    {
        $this->accessCodeService = $accessCodeService;
    }

    public function index(Request $request)
    {

    }

    public function generate(Request $request)
    {
        $request->validate(['user_id' => 'required|exists:Mst_SWIS,SWIS_ID']);

        $this->accessCodeService->index($request->user_id);

        return response()->json(['message' => 'Access code generated and sent successfully.'], 200);
    }


    public function validateCode(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:Mst_SWIS,SWIS_ID',
                'access_code' => 'required|string'
            ]);

            $isValid = $this->accessCodeService->validateCode($request->user_id, $request->access_code);

            return response()->json($isValid);
            
        } catch (\Exception $e) {
            \Log::error('Error in validation: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }

    }
}
