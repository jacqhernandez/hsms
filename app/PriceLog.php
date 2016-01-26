<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceLog extends Model
{
    protected $fillable = [
    	'date',
    	'price',
    	'stock_availability',
    	'supplier_id',
    	'item_id'
	];

	public function Supplier()
	{
		return $this->belongsTo('App\Supplier');
	}

	public function Item()
	{
		return $this->belongsTo('App\Item');
	}

}
