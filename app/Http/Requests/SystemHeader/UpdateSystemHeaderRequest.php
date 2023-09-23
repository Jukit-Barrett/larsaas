<?php

namespace App\Http\Requests\SystemHeader;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSystemHeaderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() : bool
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
            "id"  => "integer|between:0,9223372036854775807",
"systemId"  => "integer|between:0,9223372036854775807",
"headerKey" => "string|nullable|between:0,32",
"headerVal" => "string|nullable|between:0,64",
"status"  => "integer|between:0,255",
"uniqueColumn"  => "integer|between:0,255",
"sort"  => "integer|between:0,4294967295",
"createdAt" => "date|nullable",
"updatedAt" => "date|nullable",
"deletedAt" => "date|nullable",

        ];
    }

    /**
     * @desc 规则消息
     * @return array
     */
    public function messages() : array
    {
        return [
            "id.integer" => "字段 id 格式错误",
"id.between" => "字段 id 超出范围",
"systemId.integer" => "字段 systemId 格式错误",
"systemId.between" => "字段 systemId 超出范围",
"headerKey.string" => "字段 headerKey 格式错误",
"headerKey.between" => "字段 headerKey 超出范围",
"headerVal.string" => "字段 headerVal 格式错误",
"headerVal.between" => "字段 headerVal 超出范围",
"status.integer" => "字段 status 格式错误",
"status.between" => "字段 status 超出范围",
"uniqueColumn.integer" => "字段 uniqueColumn 格式错误",
"uniqueColumn.between" => "字段 uniqueColumn 超出范围",
"sort.integer" => "字段 sort 格式错误",
"sort.between" => "字段 sort 超出范围",
"createdAt.date" => "字段 createdAt 日期格式错误",
"updatedAt.date" => "字段 updatedAt 日期格式错误",
"deletedAt.date" => "字段 deletedAt 日期格式错误",

        ];
    }
}
