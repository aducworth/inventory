<?php

use App\Product;
use App\Store;
use App\Source;
use App\Location;
use App\Purchase;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class LinkProductToSource extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->integer('source_id')->default(0);
        });
        
        // update all of the products to have the source id of their purchase
        $products = Product::orderBy('name','asc')->get();
        
        foreach( $products as $product ) {
	        
	        if( $product->purchase && $product->purchase->source_id > 0 ) {
		        
		        $product->source_id = $product->purchase->source_id;
		        $product->save();
		        
	        }
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('source_id');
        });
    }
}
