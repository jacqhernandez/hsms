<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
	use SoftDeletes;
	
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
}
