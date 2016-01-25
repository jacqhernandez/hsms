<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Client extends Model implements LogsActivityInterface
{
	use LogsActivity;

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

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'updated')
	    {
	        return 'Client ' . $this->name . '  was updated';
	    }
	    return '';
	}
}
