<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Store;
use App\Source;
use App\Location;
use App\Purchase;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
	
	private $product_statuses = [0 => 'Pending',1 => 'For Sale',3 => 'Sold'];
	
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
	 * Save bulk products.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function bulk(Request $request)
	{
		if( count( $request->products ) > 0 && $request->bulk_status != '' ) {
			
			foreach( $request->products as $id ) {
				
				$product = Product::find($id);
				
				if( $product->id ) {
					
					$product->product_status = $request->bulk_status;
										
					$product->save();
					
				}
				
			}
			
		}
		
		return redirect('/product?status=' . $request->bulk_status);
	}
    
    /**
	 * Create a new product.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		
	    $this->validate($request, [
	        'name' 			=> 'required|max:255',
	        'store_id' 		=> 'required',
	        'location_id' 	=> 'required',
	        'source_id' 	=> 'required',
	    ]);
	    
	    if( !$request->id ) {
		    
		    $request->quantity = ($request->quantity?$request->quantity:1);
		    
		    Product::create([
		        'name' 				=> $request->name,
		        'store_id'			=> $request->store_id,
		        'location_id'		=> $request->location_id,
		        'source_id'			=> $request->source_id,
		        'purchase_price'	=> $request->purchase_price,
		        'sale_price'		=> $request->sale_price,
		        'shipping_paid'		=> $request->shipping_paid,
		        'actual_shipping'	=> $request->actual_shipping,
		        'seller_fee'		=> $request->seller_fee,
		        'shipping_fee'		=> $request->shipping_fee,
		        'product_status'	=> $request->product_status,
		        'quantity'			=> $request->quantity,
		        'quantity_sold'		=> $request->quantity_sold,
		        'improvement_hours'	=> $request->improvement_hours,
		        'improvement_dollars' => $request->improvement_dollars
		    ]);
		    
	    } else {
		    
		    $product = Product::find($request->id);
		    
		    $product->name 			   	= $request->name;
	        $product->store_id			= $request->store_id;
	        $product->location_id		= $request->location_id;
	        $product->source_id			= $request->source_id;
	        $product->purchase_price	= $request->purchase_price;
	        $product->sale_price		= $request->sale_price;
	        $product->shipping_paid	   	= $request->shipping_paid;
	        $product->actual_shipping	= $request->actual_shipping;
	        $product->seller_fee		= $request->seller_fee;
	        $product->shipping_fee		= $request->shipping_fee;
	        $product->product_status	= $request->product_status;
	        $product->quantity			= $request->quantity;
	        $product->quantity_sold		= $request->quantity_sold;
	        $product->improvement_hours	= $request->improvement_hours;
	        $product->improvement_dollars = $request->improvement_dollars;
	        
	        $product->save();
		    
	    }
	
	    if( $request->submit == 'Save' ) {
		    
		    return redirect('/product');
		    
	    } else {
		    
		    return redirect('/product/create?source=' . $request->source_id . '&store=' . $request->store_id . '&location_id=' . $request->location_id);
		    
	    }
	
	    return redirect('/product');
	}
	
	/**
	 * Create product
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function create(Request $request)
	{
		
		$product = new Product;
		
		return $this->edit($request,$product);
		
	}
	
	/**
	 * Ddit product
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function edit(Request $request, Product $product)
	{
		
		$stores = Store::orderBy('name')->lists('name','id');
		$locations = Location::orderBy('name')->lists('name','id');
		$sources = Source::orderBy('name')->lists("name",'id');
		
	    return view('products.input',['stores' => $stores,'locations' => $locations, 'sources' => $sources, 'product' => $product, 'product_statuses' => $this->product_statuses]);
	}
    
    /**
	 * Display a list of all of the products
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$stores = Store::orderBy('name')->lists('name','id');
		
		$sources = Source::orderBy('name')->lists("name",'id');
		
		$query = Product::orderBy('name','asc');
		
		if( $request->store ) {
			$query->where('store_id',$request->store);
		}
		
		if( isset($request->status) && $request->status != '' ) {
			$query->where('product_status',$request->status);
		}
		
		if( $request->source ) {
			$query->where('source_id',$request->source);
		}
		
		if( $request->from_date ) {
			$query->where('updated_at','>=',date('Y-m-d',strtotime($request->from_date)));
		}
		
		if( $request->to_date ) {
			$query->where('updated_at','<=',date('Y-m-d',strtotime('+1 day',strtotime($request->to_date))));
		}
		
		$products = $query->get();
		
	    return view('products.index',['products'=>$products,'statuses' => $this->product_statuses,'stores' => $stores, 'sources' => $sources ]);
	}
	
	/**
     * Destroy the given task.
     *
     * @param  Request  $request
     * @param  Task  $task
     * @return Response
     */
    public function destroy(Request $request, Product $product)
    {
        //$this->authorize('destroy', $product);
        $product->delete();
        return redirect('/product');
    }

}
