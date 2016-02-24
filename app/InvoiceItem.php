<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class InvoiceItem extends Model implements LogsActivityInterface
{
		use LogsActivity;

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
		return $this->belongsTo('App\Item')->withTrashed();
	}

	public function getActivityDescriptionForEvent($eventName)
  {
      if ($eventName == 'created')
      {
          return 'Invoice Item for invoice ' . $this->SalesInvoice->si_no . ' was created';
      }

      if ($eventName == 'updated')
      {
          return 'Invoice Item for invoice ' . $this->SalesInvoice->si_no . ' was updated';
      }

      if ($eventName == 'deleted')
      {
          return 'Invoice Item for invoice ' . $this->SalesInvoice->si_no . ' was deleted';
      }
      return '';
  }

}
