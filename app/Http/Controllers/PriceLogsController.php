<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PriceLog;
use App\Client;
use App\User;
use Request;
use Auth;
use Carbon\Carbon;

class PriceLogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager',['except' => ['index','show','search']]);     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
    //     if (Auth::user()['role'] == 'Sales')
    //     {
    //         $clients = Client::where('user_id',Auth::user()['id'])->get();
    //     }
    //     else
    //     {
    //         $clients = Client::paginate(1);
    //         $clients->setpath('hsms/public/clients/');
    //     }
    //     return view('clients.index', compact('clients'));
    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  //   public function create()
  //   {
		// //return 'wtf';
		// //$statusOptions = ['good', 'blacklisted'];
		// $statusOptions = [];
		// $statusOptions['Good'] = 'Good';
		// $statusOptions['Blacklisted'] = 'Blacklisted';

  //       $paymentOptions = [];
  //       $paymentOptions['Cash'] = 'Cash';
  //       $paymentOptions['15 Days'] = '15 Days';
  //       $paymentOptions['30 Days'] = '30 Days';
  //       $paymentOptions['60 Days'] = '60 Days';

  //       $userOptions = User::where('role', 'Sales')->lists('username', 'id');
  //       return view('clients.create', compact('statusOptions', 'paymentOptions', 'userOptions'));
  //   }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store()
    {
        $input = Request::all();
        //print_r(array_values($input));
        $priceLog = new PriceLog;
        $priceLog->date = Carbon::now();
		$priceLog->price = $input['item_price'];
        $priceLog->stock_availability = $input['stock_availability'];
        $priceLog->supplier_id = $input['supplier_id'];
        $priceLog->item_id = $input['item_id'];
		$priceLog->save();
    
        return response()->json();
        //return redirect()->action('ClientsController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
