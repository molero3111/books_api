<?php

namespace App\Http\Requests;

use App\Rules\UsernameOrEmailRule;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'user' => ['required', 'string', 'min:1', 'max:250'],
            'password' => ['required', 'string', 'min:6', 'max:30']
        ];
    }
}
