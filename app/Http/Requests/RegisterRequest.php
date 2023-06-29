<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|unique:users|max:255',
            'last_name' => 'required|string|unique:users|max:255',
            'email' => 'required|string|email',
            'password' => ['required', 'string', 'min:8', 'regex:/^.*(?=.{1,})(?=.*[0-9]).*$/'],
            'accepted_terms' => 'required|boolean'
        ];
    }
}
