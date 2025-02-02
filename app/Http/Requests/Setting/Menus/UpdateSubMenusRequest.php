<?php

namespace App\Http\Requests\Setting\Menus;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubMenusRequest extends FormRequest
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
            'submenus_name_edit'                => 'required',
            'submenus_link_edit'                => 'required',
            'submenus_icon_edit'                => 'required',
            'parent_edit'                       => 'required',
            'submenus_description_edit'         => 'required'
        ];
    }
}
