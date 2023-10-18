<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'min:8', Password::min(10)
                ->letters()
                ->numbers()
                ->mixedCase()
                ->symbols()
                ->uncompromised(), 'confirmed'],
            'company' => 'required|string|max:255',
            'phone' => 'required|string|min:10|max:15|unique:users,phone',
            'country' => 'required|exists:countries,id',
        ];
    }
}
