<?php

namespace App\Http\Requests;

use App\Rules\ThirdPartyRule;
use Illuminate\Foundation\Http\FormRequest;

class ApiThirdPartyBreachRequest extends FormRequest
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
            'type' => 'required|in:domain,phone,ip_address,username,email',
            'query' => ['required', new ThirdPartyRule($this->input('type'))]
        ];
    }
}
