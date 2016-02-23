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
        switch($this->method())
        {
            case 'POST':
            {
                return [
                    'name' => 'required',
                    'telephone_number' => 'required|numeric',
                    'address' => 'required',
                    'tin' => 'required|numeric|digits:12|unique:suppliers',
                    'email' => 'email'
                ];
            }
            case 'PATCH':
            {
                $supplier = Supplier::find($this->segment(2)); //this gets the second segment in the url which is the id of the supplier
                if ($this->get('tin') == $supplier['tin'])
                {
                    return[
                    'name' => 'required',
                    'telephone_number' => 'required|numeric',
                    'address' => 'required',
                    'tin' => 'required|numeric|digits:12|unique:suppliers,id'.$this->get('id'),
                    'email' => 'email'
                    ];
                }
                else
                {
                    return[
                    'name' => 'required',
                    'telephone_number' => 'required|numeric',
                    'address' => 'required',
                    'tin' => 'required|numeric|digits:12|unique:suppliers',
                    'email' => 'email'
                    ];
                }
            }
            default:break;
        }
    }
}


