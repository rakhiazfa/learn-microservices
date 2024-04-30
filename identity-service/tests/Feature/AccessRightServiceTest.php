<?php

use App\Http\Requests\CreateAccessRightRequest;
use App\Http\Requests\UpdateAccessRightRequest;
use App\Models\AccessRight;
use App\Services\AccessRightService;
use Database\Seeders\AccessRightSeeder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->accessRightService = new AccessRightService();
    $this->seed(AccessRightSeeder::class);
});

it('should be return access rights pagination', function () {
    $accessRights = $this->accessRightService->findAll();

    expect($accessRights)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($accessRights->count())->toBeGreaterThan(5);
});

it('should be return access rights collection', function () {
    $accessRights = $this->accessRightService->search();

    expect($accessRights)->toBeInstanceOf(Collection::class);
    expect($accessRights->count())->toBeGreaterThan(5);
    expect($accessRights[0])->toBeInstanceOf(AccessRight::class);
});

it('should be create an access right', function () {
    $request = new CreateAccessRightRequest([
        'name' => 'Fetch Menus',
        'method' => 'GET',
        'uri' => '/menus',
    ]);

    $accessRight = $this->accessRightService->create($request);

    expect($accessRight)->toBeInstanceOf(AccessRight::class);
    expect($accessRight->name)->toBe('Fetch Menus');
    expect($accessRight->method)->toBe('GET');
    expect($accessRight->uri)->toBe('/menus');
});

it('should be cannot create an access right', function () {
    $existingAccessRight = AccessRight::factory()->create();
    $request = new CreateAccessRightRequest([
        'name' => $existingAccessRight->name,
        'method' => $existingAccessRight->method,
        'uri' => $existingAccessRight->uri,
    ]);

    $this->accessRightService->create($request);
})->throws(BadRequestHttpException::class);

it('should be return a specific access right', function () {
    $existingAccessRight = AccessRight::factory()->create();
    $accessRight = $this->accessRightService->findById($existingAccessRight->id);

    expect($accessRight)->toBeInstanceOf(AccessRight::class);
    expect($accessRight->name)->toBe($existingAccessRight->name);
    expect($accessRight->method)->toBe($existingAccessRight->method);
    expect($accessRight->uri)->toBe($existingAccessRight->uri);
});

it('should save the access right to cache', function () {
    $existingAccessRight = AccessRight::factory()->create();
    $accessRight = $this->accessRightService->findById($existingAccessRight->id);

    $accessRightFromCache = Cache::tags(AccessRight::$cacheKey)->get($accessRight->id);

    expect($accessRightFromCache)->toBeInstanceOf(AccessRight::class);
    expect($accessRightFromCache->name)->toBe($existingAccessRight->name);
    expect($accessRightFromCache->method)->toBe($existingAccessRight->method);
    expect($accessRightFromCache->uri)->toBe($existingAccessRight->uri);
});

it('should be update an access right', function () {
    $existingAccessRight = AccessRight::factory()->create();
    $request = new UpdateAccessRightRequest([
        'name' => 'Foo',
        'method' => 'POST',
        'uri' => '/bar',
    ]);

    $accessRight = $this->accessRightService->update($request, $existingAccessRight->id);

    expect($accessRight)->toBeInstanceOf(AccessRight::class);
    expect($accessRight->name)->toBe('Foo');
    expect($accessRight->method)->toBe('POST');
    expect($accessRight->uri)->toBe('/bar');
});

it('should be delete an access right', function () {
    $existingAccessRight = AccessRight::factory()->create();

    $isDeleted = $this->accessRightService->delete($existingAccessRight->id);

    expect($isDeleted)->toBe(true);
    $this->assertDatabaseMissing('access_rights', [
        'id' => $existingAccessRight->id,
    ]);
});
