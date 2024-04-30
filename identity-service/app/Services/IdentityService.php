<?php

namespace App\Services;

use App\Http\Requests\AssignRolesRequest;
use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Models\Identity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class IdentityService
{
    public function findAll(): LengthAwarePaginator
    {
        $identities = Identity::latest()->paginate(15);

        return $identities;
    }

    public function create(CreateIdentityRequest $request): Identity
    {
        $identity = Identity::create($request->all());

        return $identity;
    }

    public function findById(string $id): Identity
    {
        $identity = Cache::tags(Identity::$cacheKey)->remember($id, 60 * 60, function () use ($id) {
            return Identity::find($id);
        });

        if (!$identity) throw new NotFoundHttpException('Identity not found');

        $identity->load('roles');

        return $identity;
    }

    public function update(UpdateIdentityRequest $request, string $id): Identity
    {
        $identity = $this->findById($id);

        $identity->update($request->all());

        return $identity;
    }

    public function delete(string $id): bool
    {
        $identity = $this->findById($id);

        return $identity->delete();
    }

    public function assignRoles(AssignRolesRequest $request, string $id): Identity
    {
        try {
            $identity = $this->findById($id);
            $roles = $request->input('roles', []);

            $identity->roles()->sync($roles);

            return $identity;
        } catch (QueryException $exception) {
            if ($exception->getCode() === "23000") {
                $bindings = $exception->getBindings();

                throw new BadRequestHttpException('Role with id ' . $bindings[1] . ' not found.');
            }
        }
    }
}
