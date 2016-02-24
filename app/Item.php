<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class Item extends Model implements LogsActivityInterface
{
	use SoftDeletes;
	use LogsActivity;
	
    protected $fillable = [
		'name',
		'unit',
		'description'
	];

	protected $dates = ['deleted_at'];

	public function PriceLogs()
	{
		return $this->hasMany('App\PriceLog');
	}

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'created')
	    {
	        return 'Item ' . $this->name . ' was created';
	    }

	    if ($eventName == 'updated')
	    {
	        return 'Item ' . $this->name . ' was updated';
	    }

	    if ($eventName == 'deleted')
	    {
	        return 'Item ' . $this->name . ' was deleted';
	    }
	    return '';
	}
}
