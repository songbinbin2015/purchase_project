<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class PurchasesRequest extends FormRequest
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
            'category' => 'required',
            'name'      => 'required|between:1,255',
            'size'     => 'required',
            'thickness'     => 'required',
            'texture'     => 'required',
            'image'     => 'required',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'category.required'  => '分类必须',
            'name.required'      => '产品名称不能为空',
            'name.between'       => '分类名称长度应该在1~255位之间',
            'size.required'          => '产品尺寸必填',
            'thickness.required'      => '产品厚度必填',
            'texture.required'      => '产品材质必填',
            'image.required'      => '产品图片必填',
        ];
    }
}
