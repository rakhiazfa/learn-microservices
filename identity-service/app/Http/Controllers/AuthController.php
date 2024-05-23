<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\Request;

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
            'user' => new UserResource($user),
        ]);
    }

    public function check(Request $request)
    {
        $this->authService->check($request);

        return response()->noContent();
    }
}
