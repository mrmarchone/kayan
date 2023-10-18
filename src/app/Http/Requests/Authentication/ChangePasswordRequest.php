<?php

namespace App\Http\Requests\Authentication;

use App\Rules\ValidCurrentUserPassword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
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
            'old_password' => ['required', 'min:8', new ValidCurrentUserPassword],
            'password' => ['required', 'min:8', Password::min(10)
                ->letters()
                ->numbers()
                ->mixedCase()
                ->symbols()
                ->uncompromised(), 'confirmed'],
        ];
    }
}
