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
	 * Create a new product.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function store(Request $request)
	{
		
	    $this->validate($request, [
	        'name' => 'required|max:255',
	        'store_id' => 'required',
	        'location_id' => 'required',
	        'purchase_id' => 'required',
	    ]);
	    
	    if( !$request->id ) {
		    
		    Product::create([
		        'name' 				=> $request->name,
		        'store_id'			=> $request->store_id,
		        'location_id'		=> $request->location_id,
		        'purchase_id'		=> $request->purchase_id,
		        'purchase_price'	=> $request->purchase_price,
		        'sale_price'		=> $request->sale_price,
		        'shipping_paid'		=> $request->shipping_paid,
		        'actual_shipping'	=> $request->actual_shipping,
		        'seller_fee'		=> $request->seller_fee,
		        'shipping_fee'		=> $request->shipping_fee,
		        'product_status'	=> $request->product_status
		    ]);
		    
	    } else {
		    
		    $product = Product::find($request->id);
		    
		    $product->name 			   	= $request->name;
	        $product->store_id			= $request->store_id;
	        $product->location_id		= $request->location_id;
	        $product->purchase_id		= $request->purchase_id;
	        $product->purchase_price	= $request->purchase_price;
	        $product->sale_price		= $request->sale_price;
	        $product->shipping_paid	   	= $request->shipping_paid;
	        $product->actual_shipping	= $request->actual_shipping;
	        $product->seller_fee		= $request->seller_fee;
	        $product->shipping_fee		= $request->shipping_fee;
	        $product->product_status	= $request->product_status;
	        
	        $product->save();
		    
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
		$purchases = Purchase::orderBy('purchase_date')->join('sources as s', 's.id', '=', 'purchases.source_id')
    ->selectRaw('CONCAT(purchases.purchase_date, " - ", s.name) as concatname, purchases.id')->lists("concatname",'id');
		
	    return view('products.input',['stores' => $stores,'locations' => $locations, 'purchases' => $purchases, 'product' => $product, 'product_statuses' => $this->product_statuses]);
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
		
		$query = Product::orderBy('name','asc');
		
		if( $request->store ) {
			$query->where('store_id',$request->store);
		}
		
		if( $request->status ) {
			$query->where('product_status',$request->status);
		}
		
		if( $request->from_date ) {
			$query->where('updated_at','>=',date('Y-m-d',strtotime($request->from_date)));
		}
		
		if( $request->to_date ) {
			$query->where('updated_at','<=',date('Y-m-d',strtotime('+1 day',strtotime($request->to_date))));
		}
		
		$products = $query->get();

	    return view('products.index',['products'=>$products,'statuses' => $this->product_statuses,'stores' => $stores ]);
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
