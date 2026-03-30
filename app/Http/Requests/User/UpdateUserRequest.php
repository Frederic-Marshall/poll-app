<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:50',
            'nickname' => [
                'required',
                'string',
                'max:10',
                Rule::unique('users')->ignore($this->user->id),
            ],
            'email' => [
                'required',
                'email',
                'max:255',
                'string',
                Rule::unique('users')->ignore($this->user->id)
            ],
        ];
    }
}
