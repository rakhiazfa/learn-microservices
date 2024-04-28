<?php

namespace App\Services;

use App\Http\Requests\CreateAccessRightRequest;
use App\Http\Requests\UpdateAccessRightRequest;
use App\Models\AccessRight;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class AccessRightService
{
    public function findAll(): LengthAwarePaginator
    {
        $accessRights = AccessRight::latest()->paginate(15);

        return $accessRights;
    }

    public function search(Request $request): Collection
    {
        $accessRights = AccessRight::latest()->get();

        return $accessRights;
    }

    public function create(CreateAccessRightRequest $request): AccessRight
    {
        $accessRight = AccessRight::create($request->all());

        return $accessRight;
    }

    public function findById(string $id): AccessRight
    {
        $accessRight = AccessRight::findOrFail($id);

        return $accessRight;
    }

    public function update(UpdateAccessRightRequest $request, string $id): AccessRight
    {
        $accessRight = $this->findById($id);

        $accessRight->update($request->all());

        return $accessRight;
    }

    public function delete(string $id): bool
    {
        $accessRight = $this->findById($id);

        return $accessRight->delete();
    }
}
