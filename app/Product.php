<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','notes','store_id','location_id','purchase_id','purchase_price','sale_price','sale_price','shipping_price','actual_shipping','seller_fee','transaction_fee','product_status','quantity','quantity_sold','improvement_hours','improvement_dollars','source_id'];
       
    /**
     * Overriding base save to check first if status is sold and if so, if quantity sold = quantity.
     *
     * @param  array  $options
     * @return bool
     */
    public function save(array $options = [])
    {
	    if( $this->product_status == 3 ) {
		    
		    $this->quantity_sold = $this->quantity;
		    
	    }
	    
	    return parent::save($options);
	    
	} 
	
    /**
     * Get the store.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }
    
    /**
     * Get the source.
     */
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
    
    /**
     * Get the location.
     */
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    
    /**
     * Get the purchase.
     */
    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }
    
    /**
     * Get the snapshots.
     */
    public function snapshots()
    {
        return $this->belongsToMany(Snapshot::class);
    }
}
