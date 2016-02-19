<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['store_id','amount','notes','purchase_date'];

    /**
     * Get the store.
     */
    public function store()
    {
        return $this->belongsTo(Store::class);
    }

}
