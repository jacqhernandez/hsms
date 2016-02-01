<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Spatie\Activitylog\LogsActivityInterface;
//use Spatie\Activitylog\LogsActivity;

class CollectionLog extends Model
{
    //use LogsActivity;

    //
    protected $fillable = [
		'date',
		'action',
		'follow_up_date',
		'note',
		'reason_id',
		'user_id'

		
	];
	public function Reason()
    {
        return $this->belongsTo('App\Reason');
    }
    public function Client()
    {
    	return $this->belongsTo('App\Client');
    }
    public function SalesInvoiceCollectionLog()
    {
    	return $this->hasMany('App\SalesInvoiceCollectionLog');
    }
}
