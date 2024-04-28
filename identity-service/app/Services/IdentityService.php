<?php

namespace App\Services;

use App\Http\Requests\AssignRolesRequest;
use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Models\Identity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\QueryException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

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
        $identity = Identity::with('roles')->findOrFail($id);

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

                throw new UnprocessableEntityHttpException('Role with id ' . $bindings[1] . ' not found.');
            }
        }
    }
}
