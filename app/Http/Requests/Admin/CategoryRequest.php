<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
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
            'parent_id' => 'required',
            'name'      => 'required|between:1,20',
            'path'     => 'max:256',
            'code'     => 'max:50',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'parent_id.required'  => '表单不合法',
            'name.required'      => '分类名称不能为空',
            'name.between'       => '分类名称长度应该在1~20位之间',
            'path.max'          => '设置路径过长不能多于256个',
            'code.max'      => '分类编码过长不能多于50个字符',
        ];
    }
}
