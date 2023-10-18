<?php

namespace App\Http\Requests;

use App\Models\BinResult;
use App\Rules\ThirdPartyRule;
use Illuminate\Foundation\Http\FormRequest;

class BankCardUpdateRequest extends FormRequest
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
        $id = BinResult::findOrFailByHashId($this->route('corp_card'))->id;
        return [
            'bin' => ['required', 'regex:/^[0-9]{6}$/'],
            'expire_date' => ['required', 'date'],
            'elastic_id' => 'required|unique:bin_results,elastic_id,' . $id,
            'user_id' => 'required|exists:users,id',
            'card_number' => ['required', 'regex:/^[0-9]{16}$/'],
            'cvv' => ['required', 'regex:/^[0-9]{3,4}$/']
        ];
    }
}
