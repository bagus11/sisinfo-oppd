<?php

namespace App\Http\Requests\Setting\Location;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
class AddLocationRequest extends FormRequest
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
        $post = [];
        if($request->type == 1){
            $post = [
                'name'  =>'required',
                'type'  =>'required',
                'address'  =>'required',
                'x'  =>'required',
                'y'  =>'required',
                'logo'  =>'required',
            ];
        }else{
            $post = [
                'name'  =>'required',
                'type'  =>'required',
                'parent'  =>'required',
                'address'  =>'required',
                'x'  =>'required',
                'y'  =>'required',
                'logo'  =>'required',
            ];
        }
        return $post;
        
    }
}
