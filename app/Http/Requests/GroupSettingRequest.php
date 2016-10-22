<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GroupSettingRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $segments = $this->segments();
        $id = intval(end($segments));

        $parent_id = $this->parent_id;

        switch($this->method())
        {
        case 'GET':
        case 'DELETE':
        {
            return [];
        }
        case 'POST':
        {
            return [
                'name' => 'required',
                'key' => 'required|type_key',
                'order' => 'required'
            ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
                'name' => 'required',
                'key' => 'required|unique:group_settings,key, ' . $id,
                'order' => 'required'
            ];
        }
        default:break;
        }
    }

    public function messages()
    {
        return [
            'name.required' => 'Không được để trống.',
            'key.unique' => 'Key này đã được sử dụng.',
            'key.required' => 'Không được để trống.',
            'order.required' => 'Không được để trống.',
            'key.type_key' => 'Key này đã được sử dụng.',
        ];
    }
}
