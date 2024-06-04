<?php

namespace App\Http\Requests;

use App\Http\Requests\ProtectedRequest;
use Illuminate\Auth\Access\Response;

class StoreUpdateAuthorRequest extends ProtectedRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'role_id'=>'nullable',
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string',
        ];
    }
}
