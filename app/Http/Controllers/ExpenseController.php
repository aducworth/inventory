<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Store;
use App\Expense;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Storage;

class ExpenseController extends Controller
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
	 * Save a new expense.
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
		    
		    Expense::create([
		        'store_id'			=> $request->store_id,
		        'amount'			=> $request->amount,
		        'purchase_date'		=> $request->purchase_date,
		        'notes'				=> $request->notes,
		        'receipt_url'		=> (isset($filepath)?$filepath:'')
		    ]);
		    
	    } else {
		    
		    $purchase = Expense::find($request->id);
		    
		    $purchase->notes 			   	= $request->notes;
	        $purchase->store_id				= $request->store_id;
	        $purchase->amount				= $request->amount;
	        $purchase->purchase_date		= $request->purchase_date;
	        
	        if( $receipt ) {
		        $purchase->receipt_url			= $filepath;
	        }
	        
	        
	        $purchase->save();
		    
	    }
	    	
	    return redirect('/expense');
	}
	
	/**
	 * Create expense
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function create(Request $request)
	{
		
		$expense = new Expense;
		
		return $this->edit($request,$expense);
		
	}
	
	/**
	 * Edit expense
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function edit(Request $request, Expense $expense)
	{
		
		$stores = 	Store::orderBy('name')->lists('name','id');
		
	    return view('expenses.input',['stores' => $stores,'expense' => $expense]);
	}
    
    /**
	 * Display a list of all of the expenses
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stores = Store::orderBy('name')->lists('name','id');
		
		$query = Expense::orderBy('purchase_date','desc');
		
		if( $request->store ) {
			$query->where('store_id',$request->store);
		}
		
		if( $request->from_date ) {
			$query->where('purchase_date','>=',date('Y-m-d',strtotime($request->from_date)));
		}
		
		if( $request->to_date ) {
			$query->where('purchase_date','<=',date('Y-m-d',strtotime($request->to_date)));
		}
		
		$expenses = $query->get();

	    return view('expenses.index',['expenses'=>$expenses,'stores'=>$stores]);
	}
	
	/**
     * Destroy the given expense.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Expense $expense)
    {
        //$this->authorize('destroy', $product);
        $expense->delete();
        return redirect('/expense');
    }
}
