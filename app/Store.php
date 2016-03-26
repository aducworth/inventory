<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    /**
     * Get all of the products for the store.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    /**
     * Get all of the snapshots for the store.
     */
    public function snapshots()
    {
        return $this->hasMany(Snapshot::class);
    }
}
