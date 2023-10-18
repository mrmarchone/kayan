<?php

namespace App\Http\Requests;

use App\Models\Role;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdateRequest extends FormRequest
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
        $roleId = Role::findOrFailByHashId($this->route('role'))->id;
        $typeValidation = auth()->user()->type == 'admin' ? ['type' => 'required|in:admin,client,demo'] : [];
        return [
            'name' => 'required|max:30|unique:roles,name,' . $roleId,
//            'guard_name' => 'required|max:10|in:web',
            'permissions' => 'required|array',
            'permissions.*' => 'required|exists:permissions,id',
            ...$typeValidation
        ];
    }
}
