<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignInRequest;
use App\Models\AccessRight;
use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
            'token' => $token,
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

        PersonalAccessToken::where('token', $accessToken)->update(['revoked' => true]);

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

    public function check(Request $request)
    {
        Log::info($request->headers);

        $token = $request->bearerToken();
        $method = $request->header('X-Original-Method');
        $uri = $request->header('X-Original-Uri');
        $withoutAuthorization = $request->header('X-Without-Authorization');

        $personalAccessToken = PersonalAccessToken::where([
            ['token', $token],
            ['revoked', false],
        ])->first();

        if (!auth()->guard('api')->check() || !$personalAccessToken) {
            return response()->json([
                'message' => 'Unauthenticated.',
            ], 401);
        }

        $user = auth()->user()->load('roles');
        $roleIds = $user->roles->map(fn ($role) => $role->id)->toArray();

        $isSuperAdmin = $user->roles->where('name', 'Super Admin')->first();
        $withoutAuthorization = filter_var($withoutAuthorization, FILTER_VALIDATE_BOOLEAN);

        if ($isSuperAdmin || $withoutAuthorization) return response()->noContent();

        $accessRights = DB::table('role_access_rights')
            ->join('access_rights', 'access_rights.id', 'role_access_rights.access_right_id')
            ->whereIn('role_id', $roleIds)
            ->where('access_rights.method', $method)
            ->select(['access_rights.id', 'access_rights.name', 'access_rights.method', 'access_rights.uri'])
            ->get()->toArray();

        $allowed = $this->checkAccessRight($uri, $accessRights);

        if (!$allowed) {
            return response()->json([
                'message' => 'Unauthorization.',
            ], 403);
        }

        return response()->noContent();
    }

    private function checkAccessRight($uri, $routes)
    {
        $matchedRoute = null;

        foreach ($routes as $route) {
            $pattern = str_replace('/', '\/', $route->uri);
            $pattern = preg_replace('/:(\w+)/', '(?<\1>\w+)', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches);

                $matchedRoute = $route;
            }
        }

        return !!$matchedRoute;
    }
}
