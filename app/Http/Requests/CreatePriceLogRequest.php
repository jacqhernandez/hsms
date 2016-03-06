<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Item;

class CreatePriceLogRequest extends Request
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
                    'price' => 'required|numeric|min:1'
                ];
            }
            case 'PATCH':
            {
                return [
                //
                'price' => 'required|min:1'
                ];
            }
            default:break;
        }
    }
}
