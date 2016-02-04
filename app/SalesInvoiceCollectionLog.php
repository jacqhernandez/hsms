<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceCollectionLog extends Model
{
	public $table = "sales_invoice_collection_logs";
    protected $fillable = [
		'sales_invoice_id',
		'client_id',
		'collection_log_id'
	];

	public function Client()
	{
		return $this->belongsTo('App\Client');
	}
	public function SalesInvoice()
	{
		return $this->belongsTo('App\SalesInvoice');
	}
	public function CollectionLog()
	{
		return $this->belongsTo('App\CollectionLog');
	}
}
