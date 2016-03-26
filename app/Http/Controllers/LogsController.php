<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;
use Auth;
use App\User;
use Request;
use DB;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('general_manager');     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //assumes general manager is logged in
        $activities = Activity::where('user_id','!=',Auth::user()['id'])->orderBy('created_at','desc')->paginate(10);
        //$activities = Activity::all();//orderBy('created_at','desc')->paginate(10);
        $users = User::where('role', '!=', 'General Manager')->lists('username', 'id');

        return view('logs.index', compact('activities','users'));
    }

    public function filter()
    {
        $input = Request::all();
        $filter = $input['filter'];
        $activities = Activity::where('user_id',$filter)->paginate(10);
        if ($filter == "All")
        {
            return redirect()->action('LogsController@index');
        }
        $activities->appends(Request::only('filter'));
        $users = User::where('role', '!=', 'General Manager')->lists('username', 'id');
        return view('logs.index',compact('activities','users'));
    }

    public function deleteOldestFiftyActivities()
    {
        $activities = DB::table('activity_log')->orderBy('created_at','asc')->take(50)->get();
        foreach ($activities as $activity)
            DB::table('activity_log')->where('id', '=', $activity->id)->delete();
        return redirect()->action('LogsController@index');
    }

}
