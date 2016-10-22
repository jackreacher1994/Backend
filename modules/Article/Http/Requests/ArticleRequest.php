<?php 

namespace Modules\Article\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest {
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
                'title' => 'required|unique:articles,title',
                'content' => 'required'
            ];
        }
        case 'PUT':
        case 'PATCH':
        {
            return [
                'title' => 'required|unique:articles,title,' . $id,
                'content' => 'required'
            ];
        }
        default:break;
        }
    }

    public function messages()
    {
        return [
            'title.required' => 'Vui lòng điền tiêu đề bài viết.',
            'title.unique' => 'Bài viết này đã tồn tại.',
            'content.required' => 'Vui lòng điền nội dung bài viết.'
        ];
    }
}
