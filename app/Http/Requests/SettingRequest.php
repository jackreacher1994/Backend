<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SettingRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $segments = $this->segments();
        $id = intval(end($segments));

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
                'value' => 'required',
                'key' => 'required|unique:settings,key',
                'type_id' => 'required'
            ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
                'value' => 'required',
                'key' => 'required|unique:settings,key, ' . $id,
                'type_id' => 'required'
            ];
        }
        default:break;
        }
    }

    public function messages()
    {
        return [
            'value.required' => 'Không được để trống.',
            'key.unique' => 'Key này đã được sử dụng.',
            'key.required' => 'Không được để trống.',
            'type_id.required' => 'Không được để trống.'
        ];
    }
}
