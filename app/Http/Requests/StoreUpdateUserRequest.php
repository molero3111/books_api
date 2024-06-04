<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateUserRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required_if_accepted:is_insert,1|string|max:255',
            'username' => [
                'required_if_accepted:is_insert,1',
                'string',
                'max:255',
                Rule::unique('users', 'username'), // Ensures unique username
            ],
            'email' => [
                'required_if_accepted:is_insert,1',
                'string',
                'email', // Validates email format
                'max:255',
                Rule::unique('users', 'email'), // Ensures unique email
            ],
            'password' => 'required_if_accepted:is_insert,1|string|min:4|max:255',
            'role' => 'required_if_accepted:is_insert,1|string|exists:roles,name'
        ];
    }
}
