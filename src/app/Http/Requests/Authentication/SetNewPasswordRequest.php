<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class SetNewPasswordRequest extends FormRequest
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
            'password' => ['required', 'min:8', Password::min(10)
                ->letters()
                ->numbers()
                ->mixedCase()
                ->symbols()
                ->uncompromised(), 'confirmed'],
            'email' => 'required|string|email|max:255|exists:users,email',
            'token' => 'required|string|max:255|exists:users,remember_token',
            'country' => 'required|exists:countries,id',
            'section_id' => 'required|exists:sections,id',
        ];
    }
}
