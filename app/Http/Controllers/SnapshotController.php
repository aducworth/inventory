<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Snapshot;
use App\Store;
use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class SnapshotController extends Controller
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
	 * Save a new snapshot.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		$snapshotUrl = $request->file('snapshot_url');
		
		if( $snapshotUrl ) {
			$filename = time() . '.' . $snapshotUrl->getClientOriginalExtension();
			$filepath = '/snapshots/' . $filename;
			
			if( !Storage::disk('s3')->put($filepath,file_get_contents($snapshotUrl),'public') ) {
				$filename = '';
			}
		} 
		
	    $this->validate($request, [
	        'store_id' => 'required',
	    ]);
	    
	    $item_list = array();
	    $for_sale = Product::orderBy('name')->where('store_id',$request->store_id)->where('product_status',1)->get();
	    
	    foreach( $for_sale as $item ) {
		    $item_list[] = $item->id;
	    }
	    
	    if( !$request->id ) {
		    
		    Snapshot::create([
		        'store_id'			=> $request->store_id,
		        'notes'				=> $request->notes,
		        'snapshot_products'	=> implode(',', $item_list),
		        'snapshot_url'		=> (isset($filepath)?$filepath:'')
		    ]);
		    
	    } else {
		    
		    $snapshot = Snapshot::find($request->id);
		    
	        $snapshot->store_id				= $request->store_id;
	        $snapshot->snapshot_products	= implode(',', $item_list);
	        $snapshot->notes 				= $request->notes;
	        
	        if( $snapshotUrl ) {
		        $snapshot->snapshot_url			= $filepath;
	        }
	        
	        
	        $snapshot->save();
		    
	    }
	    	
	    return redirect('/snapshot');
	}
	
	/**
	 * Create snapshot
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function create(Request $request)
	{
		
		$snapshot = new Snapshot;
		
		return $this->edit($request,$snapshot);
		
	}
	
	/**
	 * Edit snapshot
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function edit(Request $request, Snapshot $snapshot)
	{
		
		$stores = Store::orderBy('name')->lists('name','id');
		
	    return view('snapshots.input',['stores' => $stores,'snapshot' => $snapshot]);
	}
    
    /**
	 * Display a list of all of the snapshots
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$query = Snapshot::orderBy('created_at','desc');
		
		if( $request->from_date ) {
			$query->where('purchase_date','>=',date('Y-m-d',strtotime($request->from_date)));
		}
		
		if( $request->to_date ) {
			$query->where('purchase_date','<=',date('Y-m-d',strtotime($request->to_date)));
		}
		
		$snapshots = $query->get();

	    return view('snapshots.index',['snapshots'=>$snapshots]);
	}
	
	/**
     * Destroy the given snapshots.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Snapshot $snapshot)
    {
        //$this->authorize('destroy', $product);
        $snapshot->delete();
        return redirect('/snapshot');
    }

}
