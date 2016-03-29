<?php

use App\Product;
use App\Store;
use App\Source;
use App\Location;
use App\Purchase;
use App\Snapshot;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProductSnapshots extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_snapshot', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('product_id')->default(0);
            $table->integer('snapshot_id')->default(0);
            $table->timestamps();
        });
        
        // rows have been stored in a comma delimited list, get them out and store in db
        $snapshots = Snapshot::orderBy('created_at','asc')->get();
        
        foreach( $snapshots as $snapshot ) {
	        
	        if( $snapshot->snapshot_products != '' ) {
		        
		        $products = explode(',',$snapshot->snapshot_products);
		        
		        if(count($products)) {
			        
			        foreach($products as $product) {
				        
				        $snapshot->products()->attach($product);
				        
			        }
			        
		        }
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
        Schema::drop('product_snapshot');
    }
}
