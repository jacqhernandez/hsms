<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use Spatie\Activitylog\Models\Activity;
use Auth;
use App\User;
use App\SalesInvoice;
use App\CollectionLog;



class DashboardController extends Controller
{
    //
    //  public function __construct()
    // {
    //     $this->middleware('auth');  
    //     $this->middleware('general_manager');     
    // }


    public function index()
    {
    	//collected - sale invoices where due date = this week and status is collected

        if (Auth::user()->role == 'General Manager' || Auth::user()->role == 'Accounting')
        {
        	$currentCollected = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
    											WHERE week(due_date) = week(now())
    											AND status='collected'");

        	if ($currentCollected[0]->num == 0)
        	{
        		$currentAmount = 0;
        		$currentCount = 0;
        	}
        	else
        	{
        		$currentAmount = $currentCollected[0]->total;
        		$currentCount = $currentCollected[0]->num;
        	}

        	//current collectibles - sale invoices where due date = this week and status is delivered

        	$currentCollectibles = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
    											WHERE week(due_date) = week(now())
    											AND status='delivered'");

        	if ($currentCollectibles[0]->num == 0)
        	{
        		$currentCollectibleAmount = 0;
        		$currentCollectibleCount = 0;
        	}
        	else
        	{
        		$currentCollectibleAmount = $currentCollectibles[0]->total;
        		$currentCollectibleCount = $currentCollectibles[0]->num;
        	}

        	//upcoming collectibles - sale invoices where due date = next week and status is delivered

        	$upcomingCollectibles = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
    											WHERE week(due_date) - week(now()) = 1
    											AND status='delivered'");

        	if ($upcomingCollectibles[0]->num == 0)
        	{
        		$upcomingCollectibleAmount = 0;
        		$upcomingCollectibleCount = 0;
        	}
        	else
        	{
        		$upcomingCollectibleAmount = $upcomingCollectibles[0]->total;
        		$upcomingCollectibleCount = $upcomingCollectibles[0]->num;
        	}

        	//overdue collectibles - sale invoices where date difference of due date and today is > 7 and status is delivered

        	$overdueCollectibles = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
    											WHERE  week(now()) - week(due_date) >= 1
    											AND status='overdue'");

        	if ($overdueCollectibles[0]->num == 0)
        	{
        		$overdueCollectibleAmount = 0;
        		$overdueCollectibleCount = 0;
        	}
        	else
        	{
        		$overdueCollectibleAmount = $overdueCollectibles[0]->total;
        		$overdueCollectibleCount = $overdueCollectibles[0]->num;
        	}

        	$dailySales = DB::SELECT("SELECT DATE_FORMAT(date,'%m-%d-%y') as 'date', sum(total_amount) as 'total' FROM sales_invoices
        								WHERE YEAR(date) = YEAR(NOW()) AND status != 'draft'
        								GROUP BY date");


            //FOR DONUT CHART. MONTH OVERVIEW OF COLLECTED / COLLETIBLES

            $currentCollectedMonth = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
                                                WHERE MONTH(due_date) = MONTH(now())
                                                AND status='collected'");

            if ($currentCollectedMonth[0]->num == 0)
            {
                $currentAmountMonth = 0;
                //$currentCountMonth = 0;
            }
            else
            {
                $currentAmountMonth = $currentCollectedMonth[0]->total;
                //$currentCountMonth = $currentCollected[0]->num;
            }

            //current collectibles - sale invoices where due date = this week and status is delivered

            $currentCollectiblesMonth = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
                                                WHERE MONTH(due_date) = MONTH(now())
                                                AND status='delivered'");

            if ($currentCollectiblesMonth[0]->num == 0)
            {
                $currentCollectibleAmountMonth = 0;
                //$currentCollectibleCountMonth = 0;
            }
            else
            {
                $currentCollectibleAmountMonth = $currentCollectiblesMonth[0]->total;
                //$currentCollectibleCountMonth = $currentCollectibles[0]->num;
            }

            $overdueCollectiblesMonth = DB::SELECT("SELECT sum(total_amount) as 'total', count(*) as 'num' FROM sales_invoices
                                                WHERE  WEEK(now()) - WEEK(due_date) >= 1
                                                AND MONTH(due_date) = MONTH(now())
                                                AND status='overdue'");

            if ($overdueCollectiblesMonth[0]->num == 0)
            {
                $overdueCollectibleAmountMonth = 0;
                //$overdueCollectibleCountMonth = 0;
            }
            else
            {
                $overdueCollectibleAmountMonth = $overdueCollectiblesMonth[0]->total;
                //$overdueCollectibleCountMonth = $overdueCollectibles[0]->num;
            }

            $activities = Activity::where('user_id','!=',Auth::user()['id'])->orderBy('created_at','desc')->take(10);
            $users = User::where('role', '!=', 'General Manager')->lists('username', 'id');

            $collection_logs = CollectionLog::all()->take(10);


        	return view('pages.home', compact('currentAmount', 'currentCount', 'currentCollectibleCount', 'currentCollectibleAmount',
        		'upcomingCollectibleCount', 'upcomingCollectibleAmount', 'overdueCollectibleCount', 'overdueCollectibleAmount', 'dailySales',
                'currentAmountMonth', 'currentCollectibleAmountMonth', 'overdueCollectibleAmountMonth', 'activities', 'users', 'collection_logs'));
        	//return $currentCollectiblesMonth[0]->total;
        }

        else if (Auth::user()->role == 'Sales')
        {
            $sales_invoices = SalesInvoice::where('user_id', Auth::user()['id'])->paginate(10);
            $dates = SalesInvoice::all()->lists('due_date','due_date');
            return view('sales_invoices.index', compact('sales_invoices','dates'));
        }
    }


    public function changeTodo()
    {
        //$collection_logs = CollectionLog::where('follow_up_date', '=', '$date')->take(10);
        return "WEW";
    }
}
