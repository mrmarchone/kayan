<?php

namespace App\Http\Requests;

use App\Rules\ThirdPartyRule;
use Illuminate\Foundation\Http\FormRequest;

class CredentialStuffingStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'elastic_id' => 'required|unique:bin_results,elastic_id',
            'user_id' => 'required|exists:users,id',
            'username' => ['required', 'regex:/^[a-zA-Z0-9 ]+$/u', 'max:50', 'min:3'],
            'password' => ['required', 'max:50', 'min:3'],
            'url' => ['required', 'regex:/^(https?:\/\/)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(\/.*)?$/'],
        ];
    }
}
