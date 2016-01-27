<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Supplier;

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
        // return [
        //     //
        //     'name' => 'required',
        //     'address' => 'required',
        //     'telephone_number' => 'required',
        //     'tin' => 'required|min:9|max:9|unique:suppliers'
        // ];

        switch($this->method())
        {
            case 'POST':
            {
                return [
                //
                    'name' => 'required',
                    'telephone_number' => 'required',
                    'address' => 'required',
                    'tin' => 'required|min:9|max:9|unique:suppliers',
                ];
            }
            case 'PATCH':
            {
                $supplier = Supplier::find($this->segment(2)); //this gets the second segment in the url which is the id of the client
                if ($this->get('tin') == $supplier['tin'])
                {
                    return[
                    'name' => 'required',
                    'telephone_number' => 'required',
                    'address' => 'required',
                    'tin' => 'required|min:9|max:9|unique:suppliers,id'.$this->get('id'),
                    ];
                }
                else
                {
                    return[
                    'name' => 'required',
                    'telephone_number' => 'required',
                    'address' => 'required',
                    'tin' => 'required|min:9|max:9|unique:suppliers',
                    ];
                }
            }
            default:break;
        }
    }
}
