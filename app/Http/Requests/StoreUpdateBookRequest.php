<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateBookRequest extends FormRequest
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
            'author_id' => [
                'required_if_accepted:is_insert,1',
                'numeric',
                Rule::exists('authors', 'id'),
            ],
            'title' => 'required_if_accepted:is_insert,1|string|min:4|max:255',
            'genre' => 'required_if_accepted:is_insert,1|string|min:4|max:50',
            'published_at' => ['required_if_accepted:is_insert,1', 'date', 'date_format:Y-m-d H:i:s'], 
        ];
    }
}
