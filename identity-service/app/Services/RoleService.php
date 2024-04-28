<?php

namespace App\Services;

use App\Http\Requests\AssignAccessRightsRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class RoleService
{
    public function findAll(): LengthAwarePaginator
    {
        $roles = Role::latest()->paginate(15);

        return $roles;
    }

    public function search(Request $request): Collection
    {
        $roles = Role::latest()->get();

        return $roles;
    }

    public function create(CreateRoleRequest $request): Role
    {
        $role = Role::create($request->all());

        return $role;
    }

    public function findById(string $id): Role
    {
        $role = Role::with('accessRights')->findOrFail($id);

        return $role;
    }

    public function update(UpdateRoleRequest $request, string $id): Role
    {
        $role = $this->findById($id);

        $role->update($request->all());

        return $role;
    }

    public function delete(string $id): bool
    {
        $role = $this->findById($id);

        return $role->delete();
    }

    public function assignAccessRights(AssignAccessRightsRequest $request, string $id): Role
    {
        try {
            $role = $this->findById($id);
            $accessRights = $request->input('access_rights', []);

            $role->accessRights()->sync($accessRights);

            return $role;
        } catch (QueryException $exception) {
            if ($exception->getCode() === "23000") {
                $bindings = $exception->getBindings();

                throw new UnprocessableEntityHttpException('Access right with id ' . $bindings[1] . ' not found.');
            }
        }
    }
}
