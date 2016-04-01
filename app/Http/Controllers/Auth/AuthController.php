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
        $invoices = SalesInvoice::whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")');
        $invoicesForClient = SalesInvoice::whereRaw('(week(now()) - week(due_date) >= 1) and (status != "Collected")')->get();

        $invoices->update(['status' => "Overdue"]);

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
