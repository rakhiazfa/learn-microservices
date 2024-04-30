<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Resources\IdentityResource;
use App\Models\PersonalAccessToken;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
        // 
    }

    public function signIn(SignInRequest $request)
    {
        $token = $this->authService->signIn($request);

        return response()->json([
            'authorization' => [
                'type' => 'Bearer',
                'token' => $token,
            ],
        ]);
    }

    public function signOut(Request $request)
    {
        $this->authService->signOut($request);

        return response()->json([
            'message' => 'Successfully logged out.',
        ]);
    }

    public function user(Request $request)
    {
        $user = $this->authService->user($request);

        return response()->json([
            'user' => new IdentityResource($user),
        ]);
    }

    public function check(Request $request)
    {
        $this->authService->check($request);

        return response()->noContent();
    }
}
