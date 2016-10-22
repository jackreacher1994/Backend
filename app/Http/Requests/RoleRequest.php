<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|unique:roles,name'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Vui lòng điền tên role.',
            'name.unique' => 'Role này đã tồn tại.'
        ];
    }
}
