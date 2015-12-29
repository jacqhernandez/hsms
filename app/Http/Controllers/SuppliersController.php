<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Supplier;
use Request;

class SuppliersController extends Controller
{
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
        return view('suppliers.create');
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
		return view ('suppliers.edit', compact('supplier'));
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
			'address' => $input['address']
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
