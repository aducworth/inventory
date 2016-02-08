<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Product;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProductController extends Controller
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
	 * Create a new product.
	 *
	 * @param  Request  $request
	 * @return Response
	 */
	public function product(Request $request)
	{
	    $this->validate($request, [
	        'name' => 'required|max:255',
	    ]);
	
	    Product::create([
	        'name' => $request->name,
	    ]);
	
	    return redirect('/products');
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
        return redirect('/products');
    }

}
