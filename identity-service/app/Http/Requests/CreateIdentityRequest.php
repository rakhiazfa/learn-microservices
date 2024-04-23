<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateIdentityRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'registration_number' => ['required', 'unique:identities'],
            'avatar' => ['nullable', 'mimes:png,jpg,jpeg,webp,gif'],
            'name' => ['required'],
            'place_of_birth' => ['required'],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required'],
            'email' => ['required', 'email', 'unique:identities'],
            'password' => ['required', 'min:8', 'confirmed'],
            'is_active' => ['nullable', 'boolean'],
        ];
    }
}
