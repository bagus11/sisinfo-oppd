<?php

namespace App\Http\Requests\Transaction\Asset\StatusDistribusi;

use Illuminate\Foundation\Http\FormRequest;

class StoreDistribusiRequest extends FormRequest
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
            'tujuan'    =>'required',
            'reporter'    =>'required',
            'catatan'    =>'required',
        ];
    }
}
