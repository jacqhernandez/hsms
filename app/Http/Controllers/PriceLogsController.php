<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\PriceLog;
use App\Supplier;
use App\Item;
use Request;
use Auth;
use Carbon\Carbon;

class PriceLogsController extends Controller
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
        
        $price_logs = PriceLog::orderBy('date', 'desc')->paginate(10);

        return view('price_logs.index', compact('price_logs'));
        
    }

    public function search()
    {
        $input = Request::all();
        $query = $input['query'];

        $item = Item::where('name', 'LIKE', "%$query%")->get();
        $supplier = Supplier::where('name', 'LIKE', "%$query%")->get();
        $price_logs = PriceLog::join('suppliers', 'price_logs.supplier_id', '=', 'suppliers.id' )
                            ->join('items', 'price_logs.item_id', '=', 'items.id')
                            ->where('suppliers.name','LIKE',"%$query%")
                            ->orWhere('items.name', 'LIKE', "%$query%")
                            ->orderBy('date', 'desc')
                            ->paginate(10);
        
        if ($price_logs == "[]")
        {
            //flash()->error('There are no clients that match your query.');
            return redirect()->action('PriceLogsController@index');
        }
        $price_logs->appends(Request::only('query'));
        return view('price_logs.index',compact('price_logs'));
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
		$supplierOptions = Supplier::lists('name', 'id');
        $itemOptions = Item::lists('name', 'id');
        $availability = ['1' => 'Yes', '0' => 'No'];
        $date = Carbon::now()->toDateString();
        return view('price_logs.create', compact('date', 'availability', 'supplierOptions', 'itemOptions'));
    }


    public function edit($id)
    {
        $price_log = PriceLog::find($id);
        $supplierOptions = Supplier::lists('name', 'id');
        $itemOptions = Item::lists('name', 'id');
        $availability = ['1' => 'Yes', '0' => 'No'];
        $date = $price_log->date;
        return view('price_logs.edit', compact('date','availability', 'price_log', 'supplierOptions', 'itemOptions'));
    }
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

    public function store2(Requests\CreatePriceLogRequest $request)
    {
        $input = Request::all();
        //print_r(array_values($input));
        $priceLog = new PriceLog;
        $priceLog->date = Carbon::now();
        $priceLog->price = $input['price'];
        $priceLog->stock_availability = $input['stock_availability'];
        $priceLog->supplier_id = $input['supplier_id'];
        $priceLog->item_id = $input['item_id'];
        $priceLog->save();
    
        return redirect()->action('PriceLogsController@index');
        //return redirect()->action('ClientsController@index');
    }

    public function update(Requests\CreatePriceLogRequest $request, $id)
    {
        $input = Request::all();
        $priceLog = PriceLog::find($id);
        //print_r(array_values($input));
        $priceLog->update([
            'supplied_id' => $input['supplier_id'],
            'item_id' => $input['item_id'],
            'price' => $input['price'],
            'stock_availability' => $input['stock_availability']
            ]);
    
        return redirect()->action('PriceLogsController@index');
        //return redirect()->action('ClientsController@index');
    }

    public function destroy($id)
    {
        $priceLog =PriceLog::find($id);
        $priceLog->delete();
        return redirect()->action('PriceLogsController@index');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    
}
