<?php

namespace App\Http\Requests\SystemHeader;

use Illuminate\Foundation\Http\FormRequest;

class StoreSystemHeaderRequest extends FormRequest
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
        return [
            "systemId"  => "required|integer|between:0,9223372036854775807",
"headerKey" => "required|string|nullable|between:0,32",
"headerVal" => "required|string|nullable|between:0,64",
"status"  => "required|integer|between:0,255",
"uniqueColumn"  => "required|integer|between:0,255",
"sort"  => "required|integer|between:0,4294967295",

        ];
    }

    /**
     * @desc 规则消息
     * @return array
     */
    public function messages() : array
    {
        return [
            "systemId.required" => "缺少 systemId 字段",
"systemId.integer" => "字段 systemId 格式错误",
"systemId.between" => "字段 systemId 超出范围",
"headerKey.required" => "缺少 headerKey 字段",
"headerKey.string" => "字段 headerKey 格式错误",
"headerKey.between" => "字段 headerKey 超出范围",
"headerVal.required" => "缺少 headerVal 字段",
"headerVal.string" => "字段 headerVal 格式错误",
"headerVal.between" => "字段 headerVal 超出范围",
"status.required" => "缺少 status 字段",
"status.integer" => "字段 status 格式错误",
"status.between" => "字段 status 超出范围",
"uniqueColumn.required" => "缺少 uniqueColumn 字段",
"uniqueColumn.integer" => "字段 uniqueColumn 格式错误",
"uniqueColumn.between" => "字段 uniqueColumn 超出范围",
"sort.required" => "缺少 sort 字段",
"sort.integer" => "字段 sort 格式错误",
"sort.between" => "字段 sort 超出范围",

        ];
    }
}
