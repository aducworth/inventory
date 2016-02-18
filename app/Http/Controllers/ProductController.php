<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Store;
use App\Source;
use App\Location;
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
	    ]);
	    
	    if( !$request->id ) {
		    
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
		        'product_status'	=> $request->product_status
		    ]);
		    
	    } else {
		    
		    $product = Product::find($request->id);
		    
		    $product->name 			   	= $request->name;
	        $product->store_id			= $request->store_id;
	        $product->location_id		= $request->location_id;
	        $product->source_id		   	= $request->source_id;
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
		
		$stores = Store::orderBy('name')->lists('name','id');
		$locations = Location::orderBy('name')->lists('name','id');
		$sources = Source::orderBy('name')->lists('name','id');
		
	    return view('products.createedit',['stores' => $stores,'locations' => $locations, 'sources' => $sources, 'product' => $product, 'product_statuses' => $this->product_statuses]);
	}
	
	/**
	 * Ddit product
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function edit(Request $request, Product $product)
	{
		
		//$product = new Product;
		
		$stores = Store::orderBy('name')->lists('name','id');
		$locations = Location::orderBy('name')->lists('name','id');
		$sources = Source::orderBy('name')->lists('name','id');
		
	    return view('products.createedit',['stores' => $stores,'locations' => $locations, 'sources' => $sources, 'product' => $product, 'product_statuses' => $this->product_statuses]);
	}
    
    /**
	 * Display a list of all of the products
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function index(Request $request)
	{
		$products = Product::orderBy('name','asc')->get();

	    return view('products.index',['products'=>$products]);
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
