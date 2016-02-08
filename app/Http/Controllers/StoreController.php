<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Store;
use App\Http\Controllers\Controller;

class StoreController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
	 * Create a new store.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
	    $this->validate($request, [
	        'name' => 'required|max:255',
	    ]);
	
	    Store::create([
	        'name' => $request->name,
	    ]);
	
	    return redirect('/stores');
	}
    
    /**
	 * Display a list of all of the stores
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stores = Store::orderBy('name','asc')->get();

	    return view('stores.index',['stores'=>$stores]);
	}
	
	/**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Store $store)
    {
        //$this->authorize('destroy', $store);
        $store->delete();
        return redirect('/stores');
    }
}
