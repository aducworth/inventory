<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Location;
use App\Http\Controllers\Controller;

class LocationController extends Controller
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
	 * Create a new location.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function location(Request $request)
	{
	    $this->validate($request, [
	        'name' => 'required|max:255',
	    ]);
	
	    Location::create([
	        'name' => $request->name,
	    ]);
	
	    return redirect('/locations');
	}
    
    /**
	 * Display a list of all of the locations
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$locations = Location::orderBy('name','asc')->get();

	    return view('locations.index',['locations'=>$locations]);
	}
	
	/**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Location $location)
    {
        //$this->authorize('destroy', $location);
        $location->delete();
        return redirect('/locations');
    }
}
