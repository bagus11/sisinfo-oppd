<?php

namespace App\Http\Requests\Master;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterAsset extends FormRequest
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
            'no_un' => 'required',
            'no_rangka' => 'required',
            'no_mesin' => 'required',
            'kategori' => 'required',
            'subkategori' => 'required',
            'jenis' => 'required',
            'merk' => 'required',
        ];
    }
}
