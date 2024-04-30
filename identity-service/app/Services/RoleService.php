<?php

namespace App\Services;

use App\Http\Requests\AssignAccessRightsRequest;
use App\Http\Requests\CreateRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class RoleService
{
    public function findAll(): LengthAwarePaginator
    {
        $roles = QueryBuilder::for(Role::class)
            ->allowedFilters(['name'])
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return $roles;
    }

    public function search(): Collection
    {
        $roles = QueryBuilder::for(Role::class)
            ->allowedFilters(['name'])
            ->latest()
            ->get();

        return $roles;
    }

    public function create(CreateRoleRequest $request): Role
    {
        $role = Role::create($request->all());

        return $role;
    }

    public function findById(string $id): Role
    {
        $role = Cache::tags(Role::$cacheKey)->remember($id, 60 * 60, function () use ($id) {
            return Role::find($id);
        });

        if (!$role) throw new NotFoundHttpException('Role not found');

        $role->load('accessRights');

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

                throw new BadRequestHttpException('Access right with id ' . $bindings[1] . ' not found.');
            }
        }
    }
}
