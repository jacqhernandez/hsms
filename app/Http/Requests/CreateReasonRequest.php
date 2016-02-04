<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Reason;

class CreateReasonRequest extends Request
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
                    'reason' => 'required|unique:reasons'
                ];
            }
            case 'PATCH':
            {
                $reason = Reason::find($this->segment(2)); //this gets the second segment in the url which is the id of the reason
                if ($this->get('reason') == $reason['reason'])
                {
                    return[
                        'reason' => 'required|unique:reasons,id'.$this->get('id')
                    
                    ];
                }
                else
                {
                    return [
                        'reason' => 'required|unique:reasons'
                    ];
                }
            }
            default:break;
        }
    }
}
