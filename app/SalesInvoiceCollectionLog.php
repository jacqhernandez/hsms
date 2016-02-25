<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;


class SalesInvoiceCollectionLog extends Model implements LogsActivityInterface
{
	use LogsActivity;
	
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

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'created')
	    {
	        return 'Collection Log for invoice ' . $this->SalesInvoice->si_no . ' was created';
	    }

	    if ($eventName == 'updated')
	    {
	        return 'Collection Log for invoice ' . $this->SalesInvoice->si_no . ' was updated';
	    }

	    if ($eventName == 'deleted')
	    {
	        return 'Collection Log for invoice ' . $this->SalesInvoice->si_no . ' was deleted';
	    }
	    return '';
	}
}
