<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reason extends Model
{
	use SoftDeletes;

    protected $fillable = [
		'reason'
	];

	protected $dates = ['deleted_at'];
	
	public function CollectionLog()
	{
		return $this->hasMany('App\CollectionLog');
	}
}
