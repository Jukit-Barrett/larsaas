<?php

namespace App\Http\Requests\SystemHeader;

use Illuminate\Foundation\Http\FormRequest;

class IndexSystemHeaderRequest extends FormRequest
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
        $orderType = implode(",", ["-id", "+id"]);

        return [
            "page"      => "required|integer|between:0,10000",
            "perPage"   => "required|integer|between:0,10000",
            "orderType" => "string|in:{$orderType}",
        ];
    }

    /**
     * @desc 规则消息
     * @return array
     */
    public function messages() : array
    {
        return [
            "page.required" => "页码必填",
            "page.integer"  => "页码必须是整数",
            "page.between"  => "页码超出范围",

            "perPage.required" => "每页数必填",
            "perPage.integer"  => "每页数必须是整数",
            "perPage.between"  => "每页数超出范围",

            "orderType.string" => "排序类型格式错误",
            "orderType.in"     => "排序类型超出范围",
        ];
    }
}
