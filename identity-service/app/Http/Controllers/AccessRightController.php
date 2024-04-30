<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateAccessRightRequest;
use App\Http\Requests\UpdateAccessRightRequest;
use App\Http\Resources\AccessRightCollection;
use App\Http\Resources\AccessRightResource;
use App\Services\AccessRightService;

class AccessRightController extends Controller
{
    public function __construct(private AccessRightService $accessRightService)
    {
        // 
    }

    public function index()
    {
        $accessRights = $this->accessRightService->findAll();

        return new AccessRightCollection($accessRights);
    }

    public function search()
    {
        $accessRights = $this->accessRightService->search();

        return new AccessRightCollection($accessRights);
    }

    public function store(CreateAccessRightRequest $request)
    {
        $this->accessRightService->create($request);

        return response()->json([
            'message' => 'Successfully created a new access right.',
        ], 201);
    }

    public function show(string $id)
    {
        $accessRight = $this->accessRightService->findById($id);

        return new AccessRightResource($accessRight);
    }

    public function update(UpdateAccessRightRequest $request, string $id)
    {
        $this->accessRightService->update($request, $id);

        return response()->json([
            'message' => 'Successfully updated access right.',
        ]);
    }

    public function destroy(string $id)
    {
        $this->accessRightService->delete($id);

        return response()->json([
            'message' => 'Successfully deleted access right.',
        ]);
    }
}
