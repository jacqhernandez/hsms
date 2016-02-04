<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Item;

class CreateItemRequest extends Request
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
                    'name' => 'required|unique:items',
                    'unit' => 'required'
                ];
            }
            case 'PATCH':
            {
                $item = Item::find($this->segment(2)); //this gets the second segment in the url which is the id of the item
                if ($this->get('name') == $item['name'])
                {
                    return[
                    //
                        'name' => 'required|unique:items,id'.$this->get('id'),
                        'unit' => 'required'
                    
                    ];
                }
                else
                {
                    return [
                //
                    'name' => 'required|unique:items',
                    'unit' => 'required'
                    ];
                }
            }
            default:break;
        }
    }
}
