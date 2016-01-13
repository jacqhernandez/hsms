<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
		'name',
		'telephone_number',
		'address',
		'email',
		'tin',
		'contact_person',
		'credit_limit',
		'status',
		'payment_terms',
		'user_id'		
	];

	public function User()
	{
		return $this->belongsTo('App\User');
	}
}
