<?php

namespace App\Http\Requests\Setting\Menus;

use Illuminate\Foundation\Http\FormRequest;

class AddSubmenusRequest extends FormRequest
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
            'submenus_name'                => 'required',
            'submenus_link'                => 'required',
            // 'submenus_icon'                => 'required',
            'parent'                       => 'required',
            'submenus_description'         => 'required'
        ];
    }
}
