<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signIn(SignInRequest $request)
    {
        $credentials = $request->credentials();

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $user = auth()->user();

        PersonalAccessToken::create([
            'identity_id' => $user->id,
            'access_token' => $token,
            'ip_address' => $request->ip(),
        ]);

        return response()->json([
            'user' => $user,
            'authorization' => [
                'type' => 'Bearer',
                'token' => $token,
            ],
        ]);
    }

    public function signOut(Request $request)
    {
        $accessToken = $request->bearerToken();

        PersonalAccessToken::where('access_token', $accessToken)->update(['revoked' => true]);

        auth()->guard('api')->logout();

        return response()->json([
            'message' => 'Successfully logged out.',
        ]);
    }

    public function user(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'user' => $user,
        ]);
    }
}
