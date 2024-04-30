<?php

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->roleService = new RoleService();
    $this->seed(RoleSeeder::class);
});

it('should be return roles pagination', function () {
    $roles = $this->roleService->findAll();

    expect($roles)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($roles->count())->toBeGreaterThan(5);
});

it('should be return roles collection', function () {
    $roles = $this->roleService->search();

    expect($roles)->toBeInstanceOf(Collection::class);
    expect($roles->count())->toBeGreaterThan(5);
    expect($roles[0])->toBeInstanceOf(Role::class);
});

it('should be create a role', function () {
    $request = new CreateRoleRequest([
        'name' => 'Foo',
    ]);

    $role = $this->roleService->create($request);

    expect($role)->toBeInstanceOf(Role::class);
    expect($role->name)->toBe('Foo');
});

it('should be cannot create a role with existing role name', function () {
    $existingRole = Role::factory()->create();
    $request = new CreateRoleRequest([
        'name' => $existingRole->name,
    ]);

    $this->roleService->create($request);
})->throws(QueryException::class);

it('should be return a specific role', function () {
    $existingRole = Role::factory()->create();
    $role = $this->roleService->findById($existingRole->id);

    expect($role)->toBeInstanceOf(Role::class);
    expect($role->name)->toBe($existingRole->name);
});

it('should save the role to cache', function () {
    $existingRole = Role::factory()->create();
    $role = $this->roleService->findById($existingRole->id);

    $roleFromCache = Cache::tags(Role::$cacheKey)->get($role->id);

    expect($roleFromCache)->toBeInstanceOf(Role::class);
    expect($roleFromCache->name)->toBe($existingRole->name);
});

it('should be update a role', function () {
    $existingRole = Role::factory()->create();
    $request = new UpdateRoleRequest([
        'name' => 'Foo Bar',
    ]);

    $role = $this->roleService->update($request, $existingRole->id);

    expect($role)->toBeInstanceOf(Role::class);
    expect($role->name)->toBe('Foo Bar');
});

it('should be delete a role', function () {
    $existingRole = Role::factory()->create();

    $isDeleted = $this->roleService->delete($existingRole->id);

    expect($isDeleted)->toBe(true);
    $this->assertDatabaseMissing('roles', [
        'id' => $existingRole->id,
    ]);
});
