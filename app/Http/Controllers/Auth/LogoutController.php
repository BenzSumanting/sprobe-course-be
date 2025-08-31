<?php

namespace App\Http\Controllers\Auth;

use App\Http\ApiResponse\ApiResponse;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function __invoke(Request $request)
    {
        $request->user()->tokens()->delete();
        return ApiResponse::success(null, 'Success', 204);
    }
}
