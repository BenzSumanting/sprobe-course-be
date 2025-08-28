<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class LoginController extends Controller
{
     public function __construct(protected UserRepository $userRepo) {}
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return $this->userRepo->login($request->email, $request->password);
    }
}
