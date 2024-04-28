<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccessRightRequest;
use App\Http\Requests\UpdateAccessRightRequest;
use App\Http\Resources\AccessRightCollection;
use App\Http\Resources\AccessRightResource;
use App\Services\AccessRightService;
use Illuminate\Http\Request;

class AccessRightController extends Controller
{
    public function __construct(private AccessRightService $accessRightService)
    {
        // 
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $accessRights = $this->accessRightService->findAll();

        return new AccessRightCollection($accessRights);
    }

    /**
     * Search the specified resource.
     */
    public function search(Request $request)
    {
        $accessRights = $this->accessRightService->search($request);

        return new AccessRightCollection($accessRights);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateAccessRightRequest $request)
    {
        $this->accessRightService->create($request);

        return response()->json([
            'message' => 'Successfully created a new access right.',
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $accessRight = $this->accessRightService->findById($id);

        return new AccessRightResource($accessRight);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAccessRightRequest $request, string $id)
    {
        $this->accessRightService->update($request, $id);

        return response()->json([
            'message' => 'Successfully updated access right.',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $this->accessRightService->delete($id);

        return response()->json([
            'message' => 'Successfully deleted access right.',
        ]);
    }
}
