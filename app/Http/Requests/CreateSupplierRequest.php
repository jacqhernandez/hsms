<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CreateSupplierRequest extends Request
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
            //
            'name' => 'required',
            'address' => 'required',
            'telephone_number' => 'required',
            'tin' => 'required|min:9|max:9'
        ];
    }
}
