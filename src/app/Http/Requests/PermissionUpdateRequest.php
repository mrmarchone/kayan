<?php

namespace App\Http\Requests;

use App\Models\Permission;
use Illuminate\Foundation\Http\FormRequest;

class PermissionUpdateRequest extends FormRequest
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
        $permissionId = Permission::findOrFailByHashId($this->route('permission'))->id;

        return [
            'name' => 'required|max:30|unique:permissions,name,' . $permissionId,
            'group' => 'nullable|max:30',
            'guard_name' => 'required|max:10|in:' . implode(',', array_keys(config('auth.guards')))
        ];
    }
}
