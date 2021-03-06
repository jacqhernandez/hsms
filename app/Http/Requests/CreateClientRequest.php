<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Client;

class CreateClientRequest extends Request
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
                //
                    'name' => 'required',
                    'telephone_number' => 'required',
                    'address' => 'required',
                    'tin' => 'required|numeric|unique:clients',
                    //'tin' => 'required|numeric',
                    'credit_limit' => 'required'
                ];
            }
            case 'PATCH':
            {
                $client = Client::find($this->segment(2)); //this gets the second segment in the url which is the id of the client
                if ($this->get('tin') == $client['tin'])
                {
                    return[
                    'name' => 'required',
                    'telephone_number' => 'required',
                    'address' => 'required',
                    //'tin' => 'required|numeric|digits:12|unique:clients,id'.$this->get('id'),
                    'tin' => 'required|numeric|unique:clients,tin,'.$this->segment(2),
                    'credit_limit' => 'required'
                    ];
                }
                else
                {
                    return[
                    'name' => 'required',
                    'telephone_number' => 'required',
                    'address' => 'required',
                    'tin' => 'required|numeric|unique:clients',
                    'credit_limit' => 'required'
                    ];
                }
            }
            default:break;
        }
    }
}
