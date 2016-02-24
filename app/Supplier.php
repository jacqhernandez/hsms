<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model 
{
	use SoftDeletes;

	protected $dates = ['deleted_at'];

	protected $fillable = [
		'name',
		'description',
		'telephone_number',
		'tin',
		'address',
		'email',
		'payment_terms',
		'contact_person'
	];

	public function PriceLogs()
	{
		return $this->hasMany('App\PriceLog');
	}
}
