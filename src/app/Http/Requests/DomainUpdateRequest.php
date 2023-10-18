<?php

namespace App\Http\Requests;

use App\Models\Domain;
use Illuminate\Foundation\Http\FormRequest;

class DomainUpdateRequest extends FormRequest
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
        $domain = Domain::findOrFailByHashId($this->route('domain'))->id;
        return [
            'domain' => ['required', 'unique:domains,domain,' . $domain, 'regex:/^(?:[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?\.)+[a-zA-Z]{2,}(?:\.)?$/'],
        ];
    }
}
