<?php

namespace App\Services;

use App\Exceptions\UnauthenticatedException;
use App\Exceptions\UnauthorizationException;
use App\Http\Requests\SignInRequest;
use App\Models\AccessRight;
use App\Models\Identity;
use App\Models\PersonalAccessToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class AuthService
{
    public function signIn(SignInRequest $request): mixed
    {
        $credentials = $request->credentials();

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            throw new UnauthenticatedException();
        }

        $user = auth()->user();

        PersonalAccessToken::create([
            'identity_id' => $user->id,
            'token' => $token,
            'ip_address' => $request->ip(),
        ]);

        return $token;
    }

    public function signOut(Request $request): bool
    {
        $accessToken = $request->bearerToken();
        $user = auth()->user();

        PersonalAccessToken::where('token', $accessToken)->update(['revoked' => true]);
        Cache::tags(Identity::$cacheKey)->forget($user->id . '.' . AccessRight::$cacheKey);

        auth()->guard('api')->logout();

        return true;
    }

    public function user(Request $request): mixed
    {
        $user = $request->user()->load('roles');

        return $user;
    }

    public function check(Request $request): bool
    {
        $token = $request->bearerToken();
        $originalMethod = $request->header('X-Original-Method');
        $originalUri = $request->header('X-Original-Uri');
        $withoutAuthorization = $request->header('X-Without-Authorization');

        $uriComponents = parse_url($originalUri);
        $originalQueryParams = $uriComponents['query'] ?? '';

        parse_str($originalQueryParams, $queryParams);

        $originalUri = $uriComponents['path'] ?? '/';
        $originalMethod = isset($queryParams['_method']) && $queryParams['_method'] === 'PUT' ? 'PUT' : $originalMethod;

        $personalAccessToken = PersonalAccessToken::where([
            ['token', $token],
            ['revoked', false],
        ])->first();

        if (!auth()->guard('api')->check() || !$personalAccessToken) {
            throw new UnauthenticatedException();
        }

        $user = auth()->user()->load('roles');
        $roleIds = $user->roles->map(fn ($role) => $role->id)->toArray();

        $isSuperAdmin = $user->roles->where('name', 'Super Admin')->first();
        $withoutAuthorization = filter_var($withoutAuthorization, FILTER_VALIDATE_BOOLEAN);

        if ($isSuperAdmin || $withoutAuthorization) return true;

        $accessRights = Cache::tags(Identity::$cacheKey)
            ->remember($user->id . '.' . AccessRight::$cacheKey, 24 * 60 * 60, function () use ($roleIds) {
                return $this->getRoleAccessRights($roleIds);
            });
        $isAllowed = $this->checkAccessRight($originalUri, $originalMethod, $accessRights);

        if (!$isAllowed) {
            throw new UnauthorizationException();
        }

        return true;
    }

    private function getRoleAccessRights(array $roleIds): array
    {
        return DB::table('role_access_rights')
            ->join('access_rights', 'access_rights.id', 'role_access_rights.access_right_id')
            ->whereIn('role_id', $roleIds)
            ->select(['access_rights.id', 'access_rights.name', 'access_rights.method', 'access_rights.uri'])
            ->get()->toArray();
    }

    private function checkAccessRight(string $originalUri, string $originalMethod, array $routes): bool
    {
        $matchedRoute = null;

        foreach ($routes as $route) {
            $pattern = str_replace('/', '\/', $route->uri);
            $pattern = preg_replace('/:(\w+)/', '(?<\1>\w+)', $pattern);
            $pattern = '/^' . $pattern . '$/';

            if (preg_match($pattern, $originalUri, $matches) && $route->method === $originalMethod) {
                array_shift($matches);

                $matchedRoute = $route;
            }
        }

        return !!$matchedRoute;
    }
}
