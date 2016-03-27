<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Client extends Model implements LogsActivityInterface
{
	use LogsActivity;
	use SoftDeletes;

	protected $dates = ['deleted_at'];

    protected $fillable = [
		'name',
		'telephone_number',
		'address',
		'email',
		'tin',
		'contact_person',
		'accounting_contact_person',
		'accounting_email',
		'credit_limit',
		'status',
		'payment_terms',
		'vat_exempt',
		'customer_id',
		'user_id'		
	];
	public function User()
	{
		return $this->belongsTo('App\User')->withTrashed();
	}
	public function CollectionLog()
	{
		return $this->hasMany('App\CollectionLog');
	}
	public function SalesInvoiceCollectionLog()
	{
		return $this->hasMany('App\SalesInvoiceCollectionLog');
	}

	public function getActivityDescriptionForEvent($eventName)
	{
	    if ($eventName == 'updated')
	    {
	        return 'Client ' . $this->name . '  was updated';
	    }
	    return '';
	}

	public function currentCredit()
	{
		return DB::select("SELECT SUM(total_amount) AS credit FROM sales_invoices WHERE client_id='$this->id' AND (status='Delivered' OR status='Check on Hand' OR status='Pending' or status='Overdue')");
	}
}
