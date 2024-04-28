<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignAccessRightsRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Http\Resources\RoleCollection;
use App\Http\Resources\RoleResource;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(private RoleService $roleService)
    {
        // 
    }

    public function index()
    {
        $roles = $this->roleService->findAll();

        return new RoleCollection($roles);
    }

    public function search(Request $request)
    {
        $roles = $this->roleService->search($request);

        return new RoleCollection($roles);
    }

    public function store(CreateRoleRequest $request)
    {
        $this->roleService->create($request);

        return response()->json([
            'message' => 'Successfully created a new role.',
        ], 201);
    }

    public function show(string $id)
    {
        $role = $this->roleService->findById($id);

        return new RoleResource($role);
    }

    public function update(UpdateRoleRequest $request, string $id)
    {
        $this->roleService->update($request, $id);

        return response()->json([
            'message' => 'Successfully updated role.',
        ]);
    }

    public function destroy(string $id)
    {
        $this->roleService->delete($id);

        return response()->json([
            'message' => 'Successfully deleted role.',
        ]);
    }

    public function assignAccessRights(AssignAccessRightsRequest $request, string $id)
    {
        $this->roleService->assignAccessRights($request, $id);

        return response()->json([
            'message' => 'Access rights successfully assigned.',
        ]);
    }
}
