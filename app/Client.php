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
		'payment terms',
		'username'

		
	];
}
