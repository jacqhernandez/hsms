<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model implements LogsActivityInterface
{
	use LogsActivity;
	use SoftDeletes;

	protected $dates = ['deletd_at'];

    protected $fillable = [
		'name',
		'telephone_number',
		'address',
		'email',
		'tin',
		'contact_person',
		'credit_limit',
		'status',
		'payment_terms',
		'user_id'		
	];
	public function User()
	{
		return $this->belongsTo('App\User');
	}
	public function CollectionLog()
	{
		return $this->hasMany('App\CollectionLog');
	}
	public function SalesInvoiceCollectionLog()
	{
		return $this->hasMany('App\SalesInvoiceCollectionLog');
	}

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'updated')
	    {
	        return 'Client ' . $this->name . '  was updated';
	    }
	    return '';
	}
}
