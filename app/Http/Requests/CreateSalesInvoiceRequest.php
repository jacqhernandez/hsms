<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\SalesInvoice;

class CreateSalesInvoiceRequest extends Request
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
        //UNFINISHED
        switch($this->method())
        {
            case 'POST':
            {
                return [
                //
                    'status' => 'required',
                    'si_no' => 'numeric|unique:sales_invoices',
                    'po_number' => 'numeric|unique:sales_invoices',
                    'dr_number' => 'numeric|unique:sales_invoices'
                ];
            }
            case 'PATCH':
            {
                $rules = array('status' => 'required');

                $sales_invoice = SalesInvoice::find($this->segment(2)); //this gets the second segment in the url which is the id of the invoice

                if ($this->get('si_no') == $sales_invoice['si_no'])
                {
                    $rules['si_no'] = 'numeric|unique:sales_invoices,si_no,'.$this->segment(2);
                }
                else
                {
                    $rules['si_no'] = 'numeric|unique:sales_invoices';
                }
                if ($this->get('po_number') == $sales_invoice['po_number'])
                {
                    $rules['po_number'] = 'numeric|unique:sales_invoices,po_number,'.$this->segment(2);
                }
                else
                {
                    $rules['po_number'] = 'numeric|unique:sales_invoices';
                }
                if ($this->get('dr_number') == $sales_invoice['dr_number'])
                {
                    $rules['dr_number'] = 'numeric|unique:sales_invoices,dr_number,'.$this->segment(2);
                }
                else
                {
                    $rules['dr_number'] = 'numeric|unique:sales_invoices';
                }
                return $rules;
            }
            default:break;
        }
    }
}
