<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IdentityResource extends JsonResource
{
    /**
     * @var string
     */
    public static $wrap = 'identity';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'registration_number' => $this->registration_number,
            'avatar' => $this->avatar,
            'name' => $this->name,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => date('d/m/Y', strtotime($this->date_of_birth)),
            'gender' => $this->gender,
            'email' => $this->email,
            'is_active' => $this->is_active,
            'roles' => $this->whenLoaded('roles', function () {
                return new RoleCollection($this->roles);
            }),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
