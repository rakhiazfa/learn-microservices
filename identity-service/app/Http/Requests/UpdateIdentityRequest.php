<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateIdentityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $identityId = $this->route('id');

        return [
            'registration_number' => ['required', Rule::unique('identities')->ignore($identityId)],
            'avatar' => ['nullable', 'mimes:png,jpg,jpeg,webp,gif'],
            'name' => ['required'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required'],
            'email' => ['required', 'email', Rule::unique('identities')->ignore($identityId)],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
