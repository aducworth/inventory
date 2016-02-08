<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];
    
    /**
     * Get all of the products for the source.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
