<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
		'name',
		'unit',
		'description'
	];

	public function PriceLogs()
	{
		return $this->hasMany('App\PriceLog');
	}
}
