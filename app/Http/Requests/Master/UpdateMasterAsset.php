<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterAsset extends FormRequest
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
            'edit_no_un' => 'required',
            'edit_no_rangka' => 'required',
            'edit_no_mesin' => 'required',
            'edit_kategori' => 'required',
            'edit_subkategori' => 'required',
            'edit_jenis' => 'required',
            'edit_merk' => 'required',
        ];
    }
}
