<?php

namespace App\Http\Controllers;



use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\CollectionLog;
use App\Reason;
use App\User;
use App\Client;
use Auth;
use Request;




class CollectionLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   public function index($id)
    {
        
        $client = Client::where('id', $id)->get();
        $collection_logs= CollectionLog::where('client_id', $id)->orderBy('date', 'desc')->paginate(10);
        return view('collection_logs.index', compact('collection_logs', 'client'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

        $actionOptions = [];
        $actionOptions['Text'] = 'Text';
        $actionOptions['Call'] = 'Call';
        $actionOptions['Fax'] = 'Fax';
        $actionOptions['Send SOA'] = 'Send SOA';
        $actionOptions['Email'] = 'Email';
        $actionOptions['Visit'] = 'Visit';
        
        $reasonOptions = Reason::lists('reason', 'id');

        return view('collection_logs.create', compact('actionOptions', 'reasonOptions', 'id'));
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
        $cLog = new CollectionLog;
        $cLog->date = $input['date'];
        $cLog->action = $input['action'];
        $cLog->follow_up_date = $input['follow_up_date'];
        $cLog->note = $input['note'];
        $cLog->reason_id = $input['reason_id'];
        $cLog->user_id = Auth::user()['id'];
        $cLog->client_id = $input['client_id'];
        $cLog->save();
        $id = $cLog->client_id;

        return redirect()->action('CollectionLogsController@index', [$id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $cLog = CollectionLog::find($id);
        return view('collection_logs.show', compact('cLog'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cLog = CollectionLog::find($id);
        return view('collection_logs.edit', compact('cLog'));
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
        $cLog = CollectionLog::find($id);
        $input = Request::all();
        $cLog->update([
            'date' => $input['date'],
            'action' => $input['action'],
            'follow_up_date' => $input['follow_up_date'],
            'note' => $input['note'],
            'reason_id' => $input['reason_id'],
            'user_id' => $input['user_id']
        ]);
        return redirect()->action('CollectionLogsController@show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $client_id)
    {
        $cLog = CollectionLog::find($id);
        $cLog->delete();
        return redirect()->action('CollectionLogsController@index', [$client_id]);
    }
}
