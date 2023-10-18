<?php

namespace App\Http\Requests;

use App\Rules\ThirdPartyRule;
use Illuminate\Foundation\Http\FormRequest;

class RejectDemoRequest extends FormRequest
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
            'reject_message' => ['required']
        ];
    }
}
