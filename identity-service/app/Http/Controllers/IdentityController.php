<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Http\Resources\IdentityCollection;
use App\Http\Resources\IdentityResource;
use App\Services\IdentityService;
use Illuminate\Http\Request;

class IdentityController extends Controller
{
    public function __construct(private IdentityService $identityService)
    {
        // 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $identities = $this->identityService->findAll();

        return new IdentityCollection($identities);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateIdentityRequest $request)
    {
        $this->identityService->create($request);

        return response()->json([
            'message' => 'Successfully created a new identity.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $identity = $this->identityService->findById($id);

        return new IdentityResource($identity);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateIdentityRequest $request, string $id)
    {
        $this->identityService->update($request, $id);

        return response()->json([
            'message' => 'Successfully updated identity.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->identityService->delete($id);

        return response()->json([
            'message' => 'Successfully deleted identity.',
        ]);
    }
}
