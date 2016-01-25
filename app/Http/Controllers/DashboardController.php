<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
    	//collected - sale invoices where due date = this week and status is collected
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
                                            WHERE  MONTH(now()) - MONTH(due_date) >= 1
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


    	return view('pages.home', compact('currentAmount', 'currentCount', 'currentCollectibleCount', 'currentCollectibleAmount',
    		'upcomingCollectibleCount', 'upcomingCollectibleAmount', 'overdueCollectibleCount', 'overdueCollectibleAmount', 'dailySales',
            'currentAmountMonth', 'currentCollectibleAmountMonth', 'overdueCollectibleAmountMonth'));
    	//return $currentCollectiblesMonth[0]->total;
    }
}
