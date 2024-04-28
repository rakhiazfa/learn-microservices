<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRolesRequest;
use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Http\Resources\IdentityCollection;
use App\Http\Resources\IdentityResource;
use App\Services\IdentityService;

class IdentityController extends Controller
{
    public function __construct(private IdentityService $identityService)
    {
        // 
    }

    public function index()
    {
        $identities = $this->identityService->findAll();

        return new IdentityCollection($identities);
    }

    public function store(CreateIdentityRequest $request)
    {
        $this->identityService->create($request);

        return response()->json([
            'message' => 'Successfully created a new identity.',
        ], 201);
    }

    public function show(string $id)
    {
        $identity = $this->identityService->findById($id);

        return new IdentityResource($identity);
    }

    public function update(UpdateIdentityRequest $request, string $id)
    {
        $this->identityService->update($request, $id);

        return response()->json([
            'message' => 'Successfully updated identity.',
        ]);
    }

    public function destroy(string $id)
    {
        $this->identityService->delete($id);

        return response()->json([
            'message' => 'Successfully deleted identity.',
        ]);
    }

    public function assignRoles(AssignRolesRequest $request, string $id)
    {
        $this->identityService->assignRoles($request, $id);

        return response()->json([
            'message' => 'Roles successfully assigned.',
        ]);
    }
}
