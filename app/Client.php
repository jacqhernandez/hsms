<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
		'name',
		'telephone_number',
		'email',
		'tin',
		'credit_limit',
		'status',
		'address'
	];
}
