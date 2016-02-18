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
    protected $fillable = ['name','notes','store_id','location_id','purchase_id','purchase_price','sale_price','sale_price','shipping_price','actual_shipping','seller_fee','transaction_fee'];
        
    /**
     * Get the store.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
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
}
