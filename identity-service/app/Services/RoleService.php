<?php

namespace App\Services;

use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
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
        $role = Role::findOrFail($id);

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
}
