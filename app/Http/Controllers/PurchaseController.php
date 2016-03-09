<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Purchase;
use App\Source;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class PurchaseController extends Controller
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
	 * Save a new purchase.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		
		$receipt = $request->file('receipt_url');
		
		if( $receipt ) {
			$filename = time() . '.' . $receipt->getClientOriginalExtension();
			$filepath = '/receipts/' . $filename;
			
			if( !Storage::disk('s3')->put($filepath,file_get_contents($receipt),'public') ) {
				$filename = '';
			}
		} 
		
	    $this->validate($request, [
	        'amount' => 'required',
	    ]);
	    
	   if( $request->purchase_date ) {
		   $request->purchase_date = date( 'Y-m-d', strtotime( $request->purchase_date ) );
	   }
	    
	    if( !$request->id ) {
		    
		    Purchase::create([
		        'source_id'			=> $request->source_id,
		        'amount'			=> $request->amount,
		        'purchase_date'		=> $request->purchase_date,
		        'notes'				=> $request->notes,
		        'receipt_url'		=> (isset($filepath)?$filepath:'')
		    ]);
		    
	    } else {
		    
		    $purchase = Purchase::find($request->id);
		    
	        $purchase->source_id			= $request->source_id;
	        $purchase->amount				= $request->amount;
	        $purchase->purchase_date		= $request->purchase_date;
	        $purchase->notes 				= $request->notes;
	        
	        if( $receipt ) {
		        $purchase->receipt_url			= $filepath;
	        }
	        
	        
	        $purchase->save();
		    
	    }
	    	
	    return redirect('/purchase');
	}
	
	/**
	 * Create purchase
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function create(Request $request)
	{
		
		$purchase = new Purchase;
		
		return $this->edit($request,$purchase);
		
	}
	
	/**
	 * Edit purchase
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function edit(Request $request, Purchase $purchase)
	{
		
		$sources = 	Source::orderBy('name')->lists('name','id');
		
	    return view('purchases.input',['sources' => $sources,'purchase' => $purchase]);
	}
    
    /**
	 * Display a list of all of the purchases
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$sources = Source::orderBy('name')->lists('name','id');
		
		$query = Purchase::orderBy('purchase_date','desc');
		
		if( $request->source ) {
			$query->where('source_id',$request->source);
		}
		
		if( $request->from_date ) {
			$query->where('purchase_date','>=',date('Y-m-d',strtotime($request->from_date)));
		}
		
		if( $request->to_date ) {
			$query->where('purchase_date','<=',date('Y-m-d',strtotime($request->to_date)));
		}
		
		$purchases = $query->get();

	    return view('purchases.index',['purchases'=>$purchases,'sources'=>$sources]);
	}
	
	/**
     * Destroy the given purchase.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Purchase $purchase)
    {
        //$this->authorize('destroy', $product);
        $purchase->delete();
        return redirect('/purchase');
    }

}
