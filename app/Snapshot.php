<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Snapshot extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['store','snapshot_url','snapshot_products','notes'];
    
    /**
     * Get the store.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
