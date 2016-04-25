<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdateStatusRequest extends Request
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
         $input = Request::all();

                 if ($input['or_number'] != 'Cash' && $input['or_number'] != 'CASH' && $input['or_number'] != 'cash')
                {
                    return [
                    //
                        'si_no' => 'numeric|unique:sales_invoices',
                        'dr_number' => 'numeric|unique:sales_invoices',
                        'or_number' => 'numeric|unique:sales_invoices'
                    ];
                }

                    return [

                        'si_no' => 'numeric|unique:sales_invoices',
                        'dr_number' => 'numeric|unique:sales_invoices'
                    ];
    }
}
