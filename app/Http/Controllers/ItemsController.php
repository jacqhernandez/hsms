<?php

namespace App\Http\Controllers;

//use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Item;
use Request;


class ItemsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');  
        $this->middleware('not_for_sales',['except' => ['index','search']]);   
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::paginate(10);
        return view('items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('items.create');
    }

    public function search()
    {
        $input = Request::all();
        $query = $input['query'];
        $items = Item::where('name','LIKE',"%$query%")->orWhere('description','LIKE',"%$query%")->paginate(10);
        if ($items == "[]")
        {
            //flash()->error('There are no suppliers that match your query.');
            return redirect()->action('ItemsController@index');
        }
        $items->appends(Request::only('query'));
        return view('items.index',compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\CreateItemRequest $request)
    {
        $input = Request::all();
        $item = new Item;
        $item->name = $input['name'];
        $item->unit = $input['unit'];
        $item->description = $input['description'];
        $item->save();
        $id = $item->id;
        return redirect()->action('ItemsController@index');
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
        $item = Item::find($id);
        return view('items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\CreateItemRequest $request, $id)
    {
        $item = Item::find($id);
        $input = Request::all();
        $item->update([
            'name' => $input['name'],
            'unit' => $input['unit'],
            'description' => $input['description']
        ]);
        return redirect()->action('ItemsController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Item::find($id);
        $item->Delete('set null');
        return redirect()->action('ItemsController@index');
    }

    public function getItemTerms() {
        $item = $_GET['item'];

        $terms = PriceLog::where('item_id', $item)->orderBy('date','desc')->take(3)->get();

        return $terms;
    }
}
