<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Reason;
use Request;
use Auth;

class ReasonsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager',['except' => ['create','store']]);     
        $this->middleware('not_for_sales',['only'=>['create']]);
    }

    public function index()
    {
        $reasons = Reason::paginate(10);
        return view('reasons.index', compact('reasons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('reasons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateReasonRequest $request)
    {
        if (Auth::user()['role'] == 'Sales'){
            return redirect('/home');
        }
        else
        {
            $input = Request::all();
            $reason = new Reason;
            $reason->reason = $input['reason'];
            $reason->save();
            $id = $reason->id;
            if (Auth::user()['role'] == 'General Manager'){
                return redirect()->action('ReasonsController@index');
            }
            elseif (Auth::user()['role'] == 'Accounting') {
                return redirect()->action('CollectiblesController@index');
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $reason = Reason::find($id);
        return view('reasons.edit', compact('reason'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateReasonRequest $request, $id)
    {
        $reason = Reason::find($id);
        $input = Request::all();
        $reason->update([
            'reason' => $input['reason']
        ]);
        return redirect()->action('ReasonsController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reason = Reason::find($id);

        $reason->Delete('set null');
        return redirect()->action('ReasonsController@index');
    }
}
