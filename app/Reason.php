<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Reason extends Model implements LogsActivityInterface
{
	use SoftDeletes;
	use LogsActivity;

    protected $fillable = [
		'reason'
	];

	protected $dates = ['deleted_at'];
	
	public function CollectionLog()
	{
		return $this->hasMany('App\CollectionLog');
	}

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'created')
	    {
	        return 'Reason ' . $this->reason . ' was created';
	    }

	    if ($eventName == 'updated')
	    {
	        return 'Reason ' . $this->reason . ' was updated';
	    }

	    if ($eventName == 'deleted')
	    {
	        return 'Reason ' . $this->reason . ' was deleted';
	    }
	    return '';
	}
}
