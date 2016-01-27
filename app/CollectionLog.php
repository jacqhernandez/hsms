<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CollectionLog extends Model
{
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
