<?php

namespace App\Http\Requests\Transaction\Asset\Inventaris;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventaris extends FormRequest
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
            'update_kondisi'=>'required',
            'update_catatan'=>'required',
        ];
    }
}
