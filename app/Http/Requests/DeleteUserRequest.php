<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password' => ['required', 'current_password'],
        ];
    }
}
