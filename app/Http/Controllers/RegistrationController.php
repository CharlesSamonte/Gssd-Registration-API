<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RegistrationService;

class RegistrationController extends Controller
{
    private $registrationService;
    public function __construct(RegistrationService $registrationService)
    {
        $this->registrationService = $registrationService;
    }
    public function store(Request $request)
    {
        return response()->json(
            $this->registrationService->register($request->all()),
        );
    }

}
