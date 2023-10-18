<?php

namespace App\Http\Requests;

use App\Models\RestrictedDomain;
use App\Models\User;
use App\Rules\EmailRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserUpdateRequest extends FormRequest
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
        $user_id = User::findOrFailByHashId($this->route('user'))->id;
        $typeValidation = auth()->user()->type == 'admin' ?
            ['type' => 'required|in:admin,client,demo', 'show_password' => 'nullable|in:on', 'domains_limit' => 'nullable|numeric|min:1', 'results_count' => ['required', 'numeric', 'regex:/^[0-9]+$/u'], 'breaches_limit' => ['nullable', 'numeric', 'regex:/^[0-9]+$/u'], 'role_id' => 'required|numeric|exists:roles,id']
            : ['role_id' => ['required', 'numeric', Rule::exists('roles', 'id')->where('created_by', auth()->user()->id)],];
        return [
            'name' => ['required', 'min:3', 'max:20', 'regex:/^[a-zA-Z ]+$/u'],
            'email' => ['required', 'email', 'unique:users,email,' . $user_id, auth()->user()->type == 'admin' ? new EmailRule(RestrictedDomain::select('domain')->get()->pluck('domain')->toArray()) : ''],
            'country_id' => 'nullable|numeric|exists:countries,id',
            'section_id' => 'nullable|numeric|exists:sections,id',
            'phone' => ['nullable', 'unique:users,phone,' . $user_id, 'min:10', 'max:16', 'regex:/^(?:\+|[^+])[0-9]+$/u'],
            'company' => ['nullable', 'max:20', 'regex:/^[a-zA-Z ]+$/u'],
            ...$typeValidation
        ];
    }
}
