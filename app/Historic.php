<?php

namespace App;

use Carbon\Carbon;
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
        'product_id',
        'current_inventory'
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
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    #################################################################################################################
    ## QUERY SCOPE
    #################################################################################################################
    public function scopeSku($query, $search)
    {
        if ($search) {
            $query->where('product_id', $search);
        }
        return $query;
    }

    public function scopePagination($query, $per_page)
    {
        if ($per_page) {
            return $query->paginate($per_page);
        }
        return $query->paginate(10);
    }

    ################################################################################################################
    ## GETTERS E MUTATORS
    ################################################################################################################
    public function getCreatedAtAttribute($value)
    {
        return (new Carbon($value))->format('d/m/Y');
    }

    public function getOperationTypeAttribute($value)
    {
        if ($value == 'credit') {
            return 'Crédito';
        }else {
            return 'Débito';
        }
    }
}
