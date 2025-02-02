<?php

namespace App\Http\Requests\Setting\Menus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenusRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'menus_name_edit'                => 'required',
            // 'menus_link_edit'                => 'required',
            'menus_icon_edit'                => 'required',
            'menus_type_edit'                => 'required',
            'menus_description_edit'         => 'required'
        ];
    }
}
