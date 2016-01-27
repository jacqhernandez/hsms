<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $fillable = [
    	'quantity',
    	'unit_price',
    	'total_price',
    	'sales_invoice_id',
    	'item_id'
	];

	public function SalesInvoice()
	{
		return $this->belongsTo('App\SalesInvoice');
	}

	public function Item()
	{
		return $this->belongsTo('App\Item');
	}

}
