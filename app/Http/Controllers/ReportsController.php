<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Item;
use Request;
use App\Client;

class ReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager');     
    }

    public function choose()
    {
        return view('reports.generate');
    }
   
    public function generate()
    {
        $input = Request::all();
        $type = $input['type'];
        $items = Item::all()->lists('name', 'id');
        $clients = Client::all()->lists('name','id');
        return view('reports.generate', compact('type','items','clients'));
    }
    public function result()
    {
        return view('reports.result', compact('items'));
    }

}
