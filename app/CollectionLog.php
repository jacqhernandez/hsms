<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;

class CollectionLog extends Model implements LogsActivityInterface
{
    use LogsActivity;

    protected $fillable = [
		'date',
		'action',
		'follow_up_date',
		'note',
		'reason_id',
		'user_id',
        'status'	
	];

	public function Reason()
    {
        return $this->belongsTo('App\Reason')->withTrashed();
    }
    public function Client()
    {
    	return $this->belongsTo('App\Client')->withTrahsed();
    }
    public function SalesInvoiceCollectionLog()
    {
    	return $this->hasMany('App\SalesInvoiceCollectionLog');
    }

    public function getActivityDescriptionForEvent($eventName)
    {
        if ($eventName == 'created')
        {
            return 'Collection Log for client' . $this->Client->name . ' was created';
        }

        if ($eventName == 'updated')
        {
            return 'Collection Log for client' . $this->Client->name . ' was updated';
        }

        if ($eventName == 'deleted')
        {
            return 'Collection Log for client' . $this->Client->name . ' was deleted';
        }
        return '';
    }
}
