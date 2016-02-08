<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Source;
use App\Http\Controllers\Controller;

class SourceController extends Controller
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
	 * Create a new source.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function source(Request $request)
	{
	    $this->validate($request, [
	        'name' => 'required|max:255',
	    ]);
	
	    Source::create([
	        'name' => $request->name,
	    ]);
	
	    return redirect('/sources');
	}
    
    /**
	 * Display a list of all of the sources
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sources = source::orderBy('name','asc')->get();

	    return view('sources.index',['sources'=>$sources]);
	}
	
	/**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Source $source)
    {
        //$this->authorize('destroy', $source);
        $source->delete();
        return redirect('/sources');
    }
}
