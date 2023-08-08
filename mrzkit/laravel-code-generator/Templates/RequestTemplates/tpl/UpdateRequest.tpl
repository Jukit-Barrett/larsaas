<?php

namespace App\Http\Requests\{{RNT}};

use Illuminate\Foundation\Http\FormRequest;

class Update{{RNT}}Request extends FormRequest
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
            {{REQUEST_UPDATE_RULE_TPL}}
        ];
    }

    /**
     * @desc 规则消息
     * @return array
     */
    public function messages() : array
    {
        return [
            {{REQUEST_UPDATE_MESSAGE_TPL}}
        ];
    }
}
