<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required|min:3|max:190',
            'category_id'   => 'required',
            'price'         => 'required|between:0.01,9999.99',
            'image_src' => 'mimes:jpeg,png,jpg|max:5064',
        ];
    }

    public function messages(){
        return [
            'name.required'=> 'The name of the application is required',
            'category_id.required'=> 'The category is required',
            'price.required'=> 'the price is mandatory',
            'price.between'=> 'The price must be between 0.01 and 9999.99',
            'image_src.mimes'=> 'The image must be of the type jpeg, png or jpg',
            'image_src.max'=> 'The image must have a maximum size of 5MB'
        ];
    }
}
