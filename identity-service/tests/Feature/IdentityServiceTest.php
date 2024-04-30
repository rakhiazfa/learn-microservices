<?php

use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Models\Identity;
use App\Services\IdentityService;
use Database\Seeders\IdentitySeeder;
use Database\Seeders\RoleSeeder;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;

uses(RefreshDatabase::class);

beforeEach(function () {
    $this->identityService = new IdentityService();

    $this->seed(RoleSeeder::class);
    $this->seed(IdentitySeeder::class);
});

it('should be return identities pagination', function () {
    $identities = $this->identityService->findAll();

    expect($identities)->toBeInstanceOf(LengthAwarePaginator::class);
    expect($identities->count())->toBeGreaterThan(5);
});

it('should be create a identity', function () {
    $request = new CreateIdentityRequest([
        'registration_number' => '1234567890987654',
        'name' => 'Foo Bar',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '2004-06-07',
        'gender' => 'Pria',
        'email' => 'foo.bar@example.co.id',
        'password' => 'password',
    ]);

    $identity = $this->identityService->create($request);

    expect($identity)->toBeInstanceOf(Identity::class);
    expect($identity->registration_number)->toBe('1234567890987654');
    expect($identity->name)->toBe('Foo Bar');
    expect($identity->place_of_birth)->toBe('Bandung');
    expect($identity->date_of_birth->format('Y-m-d'))->toBe('2004-06-07');
    expect($identity->gender)->toBe('Pria');
    expect($identity->email)->toBe('foo.bar@example.co.id');
});

it('should be cannot create a identity with existing registration number', function () {
    $existingIdentity = Identity::factory()->create();
    $request = new CreateIdentityRequest([
        'registration_number' => $existingIdentity->registration_number,
        'name' => 'Foo Bar',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '2004-06-07',
        'gender' => 'Pria',
        'email' => 'foo.bar@example.co.id',
        'password' => 'password',
    ]);

    $this->identityService->create($request);
})->throws(QueryException::class);

it('should be cannot create a identity with existing email', function () {
    $existingIdentity = Identity::factory()->create();
    $request = new CreateIdentityRequest([
        'registration_number' => '1234567890987654',
        'name' => 'Foo Bar',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '2004-06-07',
        'gender' => 'Pria',
        'email' => $existingIdentity->email,
        'password' => 'password',
    ]);

    $this->identityService->create($request);
})->throws(QueryException::class);

it('should be return a specific identity', function () {
    $existingIdentity = Identity::factory()->create();
    $identity = $this->identityService->findById($existingIdentity->id);

    expect($identity)->toBeInstanceOf(Identity::class);
    expect($identity->registration_number)->toBe($existingIdentity->registration_number);
    expect($identity->name)->toBe($existingIdentity->name);
    expect($identity->place_of_birth)->toBe($existingIdentity->place_of_birth);
    expect($identity->date_of_birth->format('Y-m-d'))->toBe($existingIdentity->date_of_birth->format('Y-m-d'));
    expect($identity->gender)->toBe($existingIdentity->gender);
    expect($identity->email)->toBe($existingIdentity->email);
});

it('should save the identity to cache', function () {
    $existingIdentity = Identity::factory()->create();
    $identity = $this->identityService->findById($existingIdentity->id);

    $identityFromCache = Cache::tags(Identity::$cacheKey)->get($identity->id);

    expect($identityFromCache)->toBeInstanceOf(Identity::class);
    expect($identityFromCache->registration_number)->toBe($existingIdentity->registration_number);
    expect($identityFromCache->name)->toBe($existingIdentity->name);
    expect($identityFromCache->place_of_birth)->toBe($existingIdentity->place_of_birth);
    expect($identityFromCache->date_of_birth->format('Y-m-d'))->toBe($existingIdentity->date_of_birth->format('Y-m-d'));
    expect($identityFromCache->gender)->toBe($existingIdentity->gender);
    expect($identityFromCache->email)->toBe($existingIdentity->email);
});

it('should be update a identity', function () {
    $existingIdentity = Identity::factory()->create();
    $request = new UpdateIdentityRequest([
        'registration_number' => '1234567890987654',
        'name' => 'Foo Bar',
        'place_of_birth' => 'Bandung',
        'date_of_birth' => '2004-06-07',
        'gender' => 'Pria',
        'email' => 'foo.bar@example.co.id',
        'password' => 'password',
    ]);

    $identity = $this->identityService->update($request, $existingIdentity->id);

    expect($identity)->toBeInstanceOf(Identity::class);
    expect($identity->registration_number)->toBe('1234567890987654');
    expect($identity->name)->toBe('Foo Bar');
    expect($identity->place_of_birth)->toBe('Bandung');
    expect($identity->date_of_birth->format('Y-m-d'))->toBe('2004-06-07');
    expect($identity->gender)->toBe('Pria');
    expect($identity->email)->toBe('foo.bar@example.co.id');
});

it('should be delete a identity', function () {
    $existingIdentity = Identity::factory()->create();

    $isDeleted = $this->identityService->delete($existingIdentity->id);

    expect($isDeleted)->toBe(true);
    $this->assertDatabaseMissing('roles', [
        'id' => $existingIdentity->id,
    ]);
});
