<?php

namespace App\Http\Requests\Transaction\Asset\Inventaris;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class StoreInventaris extends FormRequest
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
    public function rules(Request $request): array
    {
        $post =[];
        // dd($request->type);
        if($request->type== 2){
            $post =[
                // 'satgas'=>'required',
                // 'bulan'=>'required',
                // 'asset'=>'required',
                // 'reporter'=>'required',
                // 'catatan'=>'required',
                // 'kondisi'=>'required',
            ];
        }else{
            $post =[
                // 'satgas'=>'required',
                // 'bulan'=>'required',
                // 'asset'=>'required',
                // 'reporter'=>'required',
                // 'catatan'=>'required',
                // 'kondisi'=>'required',
            ];
        }
        return $post;
    }
}
