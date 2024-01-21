<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'product_name' => 'required',
            'company_id' => 'required',
            'price' => 'required',
            'stock' => 'required',
            'comment' => 'nullable',
            'img_path' => 'nullable|image|max:2048',
        ];
    }

    public function attributes()
    {
        return [
            'product_name' => '商品名',
            'company_id' => '会社ID',
            'price' => '価格',
            'stock' => '在庫',
            'comment' => 'コメント',
            'img_path' => '画像',
        ];
    }

    public function messages() {
        return [
            'product_name.required' => ':attributeは必須項目です。',
            'product_name.max' => ':attributeは:max字以内で入力してください。',
            'price.required' => ':attributeは必須項目です。',
            'price.max' => ':attributeは:max字以内で入力してください。',
            'comment.required' => ':attributeはURL形式で入力してください。',
            'comment.max' => ':attributeは:max字以内で入力してください。',
        ];
    }
}
