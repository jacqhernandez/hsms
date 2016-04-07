<?php

namespace App\Http\Controllers\Auth;

use App\Client;
use App\SalesInvoice;
use DB;
use App\CollectionLog;
use App\SalesInvoiceCollectionLog;
use Carbon\Carbon;
use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */

    protected $redirectTo = '/home';
    protected $username = 'username';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => ['logout','getRegister']]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|unique:users',
            'role' => 'required',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        return User::create([
            'username' => $data['username'],
            'role' => $data['role'],
            'password' => bcrypt($data['password']),
        ]);
    }

    protected function authenticated()
    {
        /* UPDATING OVERDUE */

        //all collectibles.. if the due date and current year is the same, then if it is a week past the due date week, it is overdue
        $invoices = SalesInvoice::whereRaw('(YEAR(now()) = YEAR(due_date)) AND (week(now()) - week(due_date) >= 1) AND (status != "Collected" AND status != "Pending" AND status != "Cancelled")');
        //all collectibles.. if the due date and current year is NOT the same, then if the week of due date is greater than current week (meaning next year na), it is overdue
        $invoicesYears = SalesInvoice::whereRaw('(YEAR(now()) - YEAR(due_date) >= 1) AND (wEEK(due_Date) - WEEK(now()) >= 1) AND (status != "Collected" AND status != "Pending" AND status != "Cancelled")');
        //if client has a sales invoice overdue for 4 months or 120 days.. make the client blacklisted.
        $invoicesForClient = SalesInvoice::whereRaw('(datediff(now(), due_date) >= 120) and (status != "Collected" AND status != "Pending" AND status != "Cancelled")')->get();

        $invoices->update(['status' => "Overdue"]);
        $invoicesYears->update(['status' =>"Overdue"]);

        foreach ($invoicesForClient as $invoice)
        {
            $client = Client::find($invoice->client_id);
            $client->update(['status' => "Blacklisted"]);
        }


        // $overdues = \DB::table('sales_invoices')->whereRaw('status = "Overdue"');

        $overdues = DB::SELECT("SELECT * FROM sales_invoices where status = 'Overdue'");
        $today = Carbon::today();
        $mondayOf = Carbon::now()->startOfWeek();

        if($today == $mondayOf)
        {
            foreach ($overdues as $overdue)
            {
                $cLog = new CollectionLog;
                $cLog->date = $mondayOf;
                $cLog->action = 'Call and Send SOA Overdue';
                $cLog->client_id = $overdue->client_id;
                $cLog->status = 'To Do';
                $cLog->save();

                $sicl = new SalesInvoiceCollectionLog;
                $sicl->sales_invoice_id = $overdue->id;
                $sicl->client_id = $cLog->client_id;
                $sicl->collection_log_id = $cLog->id;
                $sicl->save();
            }
        }
        return redirect()->action('DashboardController@index');
    }
}
