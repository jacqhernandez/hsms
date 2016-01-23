<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
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
}
