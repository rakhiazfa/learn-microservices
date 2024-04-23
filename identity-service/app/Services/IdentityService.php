<?php

namespace App\Services;

use App\Http\Requests\CreateIdentityRequest;
use App\Http\Requests\UpdateIdentityRequest;
use App\Models\Identity;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class IdentityService
{
    public function findAll(): LengthAwarePaginator
    {
        $identities = Identity::latest()->paginate(15);

        return $identities;
    }

    public function search(Request $request): Collection
    {
        $keyword = $request->query('keyword');

        $identities = Identity::when($keyword, function ($query) use ($keyword) {
            $query->where('registration_number', 'LIKE', "%{$keyword}%")
                ->orWhere('name', 'LIKE', "%{$keyword}%")
                ->orWhere('place_of_birth', 'LIKE', "%{$keyword}%")
                ->orWhere('date_of_birth', 'LIKE', "%{$keyword}%")
                ->orWhere('gender', 'LIKE', "%{$keyword}%")
                ->orWhere('email', 'LIKE', "%{$keyword}%");
        })->latest()->get();

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
