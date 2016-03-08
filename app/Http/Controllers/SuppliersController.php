<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Supplier;
use Request;

class SuppliersController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');  
        $this->middleware('not_for_sales',['except' => ['index','show', 'search']]);     

    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$suppliers = Supplier::paginate(10);
		return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $paymentOptions = [];
        $paymentOptions['Cash'] = 'Cash';
        $paymentOptions['7 Days'] = '7 Days';
        $paymentOptions['15 Days'] = '15 Days';
        $paymentOptions['30 Days'] = '30 Days';
        $paymentOptions['60 Days'] = '60 Days';
        $paymentOptions['75 Days'] = '75 Days';
        $paymentOptions['90 Days'] = '90 Days';

        return view('suppliers.create', compact('paymentOptions'));
    }

    public function search()
    {
        $input = Request::all();
        $query = $input['query'];
        $suppliers = Supplier::where('name','LIKE',"%$query%")->orWhere('description','LIKE',"%$query%")->paginate(10);
        if ($suppliers == "[]")
        {
            //flash()->error('There are no suppliers that match your query.');
            return redirect()->action('SuppliersController@index');
        }
        $suppliers->appends(Request::only('query'));
        return view('suppliers.index',compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateSupplierRequest $request)
    {
        //
		$input = Request::all();
		$supplier = new Supplier;
		$supplier->name = $input['name'];
        $supplier->description = $input['description'];
		$supplier->address = $input['address'];
		$supplier->telephone_number = $input['telephone_number'];
		$supplier->tin = $input['tin'];
        $supplier->email = $input['email'];
        $supplier->contact_person = $input['contact_person'];
        $supplier->payment_terms = $input['payment_terms'];
		$supplier->save();
		return redirect() -> action('SuppliersController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
		$supplier = Supplier::find($id);
		return view('suppliers.show', compact('supplier'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
		$supplier = Supplier::find($id);

        $paymentOptions = [];
        $paymentOptions['Cash'] = 'Cash';
        $paymentOptions['15 Days'] = '15 Days';
        $paymentOptions['30 Days'] = '30 Days';
        $paymentOptions['60 Days'] = '60 Days';

		return view ('suppliers.edit', compact('supplier', 'paymentOptions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateSupplierRequest $request, $id)
    {
        //
		$supplier = Supplier::find($id);
		$input = Request::all();
		$supplier->update([
			'name' => $input['name'],
            'description' => $input['description'],
			'telephone_number' => $input['telephone_number'],
			'tin' => $input['tin'],
			'address' => $input['address'],
            'email' => $input['email'],
            'contact_person' => $input['contact_person'],
            'payment_terms' => $input['payment_terms']
		]);
		return redirect()->action('SuppliersController@show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
		$supplier = Supplier::find($id);
        $supplier->delete();
        return redirect()->action('SuppliersController@index');
    }
}
