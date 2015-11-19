<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Client;
use Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::all();
        return view('clients.index', compact('clients'));
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
        return view('clients.create', compact('statusOptions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Request::all();
        $client = new Client;
        $client->name = $input['name'];
		$client->telephone_number = $input['telephone_number'];
		$client->address = $input['address'];
        $client->email = $input['email'];
		$client->tin = $input['tin'];
        $client->credit_limit = $input['credit_limit'];
		$client->status = $input['status'];
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
        return view('clients.edit', compact('client', 'statusOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $client = Client::find($id);
        $input = Request::all();
        $client->update([
            'name' => $input['name'],
			'telephone_number' => $input['telephone_number'],
			'address' => $input['address'],
            'email' => $input['email'],
			'tin' => $input['tin'],
            'credit_limit' => $input['credit_limit'],
			'status' => $input['status']
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
