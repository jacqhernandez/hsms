<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use App\User;
use Request;
use Auth;

class ClientsController extends Controller
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
    public function index()
    {
        if (Auth::user()['role'] == 'Sales')
        {
            $clients = Client::where('user_id',Auth::user()['id'])->paginate(10);
        }
        else
        {
             // $clients = Client::all();
             $clients = Client::paginate(10);
             $clients->setpath('hsms/public/clients/');
        }
        return view('clients.index', compact('clients'));
    }

    public function search()
    {
        $input = Request::all();
        $query = $input['query'];

        if (Auth::user()['role'] == 'Sales')
        {
            $clients = Client::where('user_id',Auth::user()['id'])->where('name','LIKE',"%$query%")->paginate(10);
        }
        else
        {
            $clients = Client::where('name','LIKE',"%$query%")->paginate(10);
        }

        if ($clients == "[]")
        {
            //flash()->error('There are no clients that match your query.');
            return redirect()->action('ClientsController@index');
        }
        $clients->appends(Request::only('query'));
        return view('clients.index',compact('clients'));
    }

    public function filter()
    {
        $input = Request::all();
        $filter = $input['filter'];
        $clients = Client::where('status',$filter)->paginate(10);
        if ($clients == "[]")
        {
            return redirect()->action('ClientsController@index');
        }
        $clients->appends(Request::only('filter'));
        return view('clients.index',compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
		//return 'wtf';
		//$statusOptions = ['good', 'blacklisted'];
		$statusOptions = [];
		$statusOptions['Good'] = 'Good';
		$statusOptions['Blacklisted'] = 'Blacklisted';

        $paymentOptions = [];
        $paymentOptions['Cash'] = 'Cash';
        $paymentOptions['15 Days'] = '15 Days';
        $paymentOptions['30 Days'] = '30 Days';
        $paymentOptions['60 Days'] = '60 Days';

        $userOptions = User::where('role', 'Sales')->lists('username', 'id');
        return view('clients.create', compact('statusOptions', 'paymentOptions', 'userOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateClientRequest $request)
    {
        $input = Request::all();
        $client = new Client;
        $client->name = $input['name'];
		$client->telephone_number = $input['telephone_number'];
		$client->address = $input['address'];
        $client->email = $input['email'];
		$client->tin = $input['tin'];
        $client->contact_person = $input['contact_person'];
        $client->credit_limit = $input['credit_limit'];
		$client->status = $input['status'];
        $client->payment_terms = $input['payment_terms'];
        $client->user_id = $input['user_id'];
        $client->save();
    
        return redirect()->action('ClientsController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $client = Client::find($id);
        return view('clients.show', compact('client'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $client = Client::find($id);
		$statusOptions = [];
		$statusOptions['Good'] = 'Good';
		$statusOptions['Blacklisted'] = 'Blacklisted';

        $paymentOptions = [];
        $paymentOptions['Cash'] = 'Cash';
        $paymentOptions['15 Days'] = '15 Days';
        $paymentOptions['30 Days'] = '30 Days';
        $paymentOptions['60 Days'] = '60 Days';

        $userOptions = User::where('role', 'Sales')->lists('username', 'id');

        return view('clients.edit', compact('client', 'statusOptions', 'paymentOptions', 'userOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateClientRequest $request, $id)
    {
        $client = Client::find($id);
        $input = Request::all();
        $client->update([
            'name' => $input['name'],
			'telephone_number' => $input['telephone_number'],
			'address' => $input['address'],
            'email' => $input['email'],
			'tin' => $input['tin'],
            'contact_person' => $input['contact_person'],
            'credit_limit' => $input['credit_limit'],
			'status' => $input['status'],
            'payment_terms' => $input['payment_terms'],
            'user_id' => $input['user_id']
        ]);
        return redirect()->action('ClientsController@show',[$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $client = Client::find($id);
        $client->delete();
        return redirect()->action('ClientsController@index');
    }
}
