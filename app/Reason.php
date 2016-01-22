<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    protected $fillable = [
		'reason'
	];

	public function CollectionLog()
	{
		return $this->hasMany('App\CollectionLog');
	}
}
