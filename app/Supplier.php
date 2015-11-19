<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
	protected $fillable = [
		'name',
		'telephone_number',
		'tin',
		'address'
	];
}
