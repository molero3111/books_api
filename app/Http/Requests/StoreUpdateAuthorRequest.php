<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateAuthorRequest extends FormRequest
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
            'user_id' => [
                'required_if_accepted:is_insert,1',
                'numeric',
                Rule::exists('users', 'id'),
                Rule::unique('authors', 'user_id'),
            ],
            'nickname' => [
                'required_if_accepted:is_insert,1',
                'string',
                'max:255',
                Rule::unique('authors', 'nickname'),
            ],
        ];
    }
}
