<?php

namespace App\Http\Requests;

use App\Models\BinResult;
use App\Models\CredentialStuffing;
use App\Rules\ThirdPartyRule;
use Illuminate\Foundation\Http\FormRequest;

class CredentialStuffingUpdateRequest extends FormRequest
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
        $id = CredentialStuffing::findOrFailByHashId($this->route('credential_stuffing'))->id;
        return [
            'elastic_id' => 'required|unique:bin_results,elastic_id,' . $id,
            'user_id' => 'required|exists:users,id',
            'username' => ['required', 'regex:/^[a-zA-Z0-9 ]+$/u', 'max:50', 'min:3'],
            'password' => ['required', 'max:50', 'min:3'],
            'url' => ['required', 'regex:/^(https?:\/\/)?([a-zA-Z0-9.-]+\.[a-zA-Z]{2,})(\/.*)?$/'],
        ];
    }
}
