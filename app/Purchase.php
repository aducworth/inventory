<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','source_id','amount','receipt_url','purchase_date','notes'];

    /**
     * Get the source.
     */
    public function source()
    {
        return $this->belongsTo(Source::class);
    }
    
    /**
     * Get the products.
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
