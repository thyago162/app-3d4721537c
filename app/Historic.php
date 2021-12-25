<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historic extends Model
{
    /**
     * @var array
    */
    protected $fillable = [
        'operation_type',
        'operation_value',
        'previous_balance',
        'product_id'
    ];

    /**
     * @var array
    */
    protected $dates = [
        'created_at',
        'updated_at'
    ];

    ##################################################################################################################
    ## RELATIONSHIPS
    ##################################################################################################################
    public function products()
    {
        return $this->hasOne(Product::class);
    }
}
