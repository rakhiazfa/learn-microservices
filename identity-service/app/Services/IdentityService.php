<?php

namespace App\Services;

use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Models\Identity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

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
        $identity = Identity::findOrFail($id);

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
}
