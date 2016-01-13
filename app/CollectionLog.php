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
}
