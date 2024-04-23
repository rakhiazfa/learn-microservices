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
            'registrationNumber' => ['required', Rule::unique('identities')->ignore($identityId)],
            'avatar' => ['nullable', 'mimes:png,jpg,jpeg,webp,gif'],
            'name' => ['required'],
            'placeOfBirth' => ['required'],
            'dateOfBirth' => ['required', 'date'],
            'gender' => ['required'],
            'email' => ['required', 'email', Rule::unique('identities')->ignore($identityId)],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'isActive' => ['nullable', 'boolean'],
        ];
    }
}
