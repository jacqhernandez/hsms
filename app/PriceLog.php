<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class PriceLog extends Model 
// implements LogsActivityInterface
{
	// use LogsActivity;

    protected $fillable = [
    	'date',
    	'price',
    	'stock_availability',
    	'supplier_id',
    	'item_id'
	];

	public function Supplier()
	{
		return $this->belongsTo('App\Supplier')->withTrashed();
	}

	public function Item()
	{
		return $this->belongsTo('App\Item')->withTrashed();
	}

	// public function getActivityDescriptionForEvent($eventName)
	// {
	//     if ($eventName == 'created')
	//     {
	//         return 'Price Log for item' . $this->Item->name . ' was created';
	//     }

	//     if ($eventName == 'updated')
	//     {
	//         return 'Price Log for item' . $this->Item->name . ' was updated';
	//     }

	//     if ($eventName == 'deleted')
	//     {
	//         return 'Price Log for otem' . $this->Item->name . ' was deleted';
	//     }
	//     return '';
	// }

}
