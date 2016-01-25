<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class SalesInvoice extends Model
{
	use LogsActivity;

    protected $fillable = [
		'si_no',
		'po_number',
		'dr_number',
		'date',
		'due_date',
		'total amount',
		'vat',
		'wtax',
		'status',
		'date_delivered',
		'date_collected',
		'client_id',
		'user_id'	
	];

	public function Client()
	{
		return $this->belongsTo('App\Client');
	}

	public function User()
	{
		return $this->belongsTo('App\User');
	}

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'created')
	    {
	        return 'Sales Invoice ' . $this->si_no . ' was created';
	    }

	    if ($eventName == 'updated')
	    {
	        return 'Sales Invoice ' . $this->si_no . ' was updated';
	    }

	    if ($eventName == 'deleted')
	    {
	        return 'Sales Invoice ' . $this->si_no . ' was deleted';
	    }

	    return '';
	}
}
