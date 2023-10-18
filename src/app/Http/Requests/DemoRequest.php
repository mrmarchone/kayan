<?php

namespace App\Http\Requests;

use App\Rules\EmailRule;
use App\Rules\ReCaptcha;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\RestrictedDomain;

class DemoRequest extends FormRequest
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
            'name' => ['bail', 'required', 'regex:/^[a-zA-Z \s]+$/', 'max:35'],
            'company' => ['bail', 'required', 'regex:/^[a-zA-Z \s]+$/', 'max:35'],
            'email' => ['bail', 'required', 'email', 'unique:demo_requests,email', new EmailRule(RestrictedDomain::select('domain')->get()->pluck('domain')->toArray())],
            'phone' => ['required', 'unique:demo_requests,phone', 'min:10', 'max:16', 'regex:/^(?:\+|[^+])[0-9]+$/u'],
            'recaptcha_response' => ['required', new ReCaptcha]
        ];
    }
}
