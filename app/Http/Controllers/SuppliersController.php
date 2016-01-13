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
         //$this->middleware('auth');  
        //$this->middleware('general_manager',['except' => ['index','show']]);     
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		$suppliers = Supplier::all();
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
        $paymentOptions['15 Days'] = '15 Days';
        $paymentOptions['30 Days'] = '30 Days';
        $paymentOptions['60 Days'] = '60 Days';

        return view('suppliers.create', compact('paymentOptions'));
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
