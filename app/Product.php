<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'sku',
        'initial_quantity',
        'price',
        'active',
    ];

    /**
     * @var array $dates
     */
    protected $dates = [
        'created_at',
        'deleted_at',
        'updated_at'
    ];

    ###################################################################################################################################################
    ## SCOPE
    ###################################################################################################################################################
    public function scopePagination($query, $per_page)
    {
        if ($per_page) {
            return $query->paginate($per_page);
        }

        return $query->paginate(10);
    }

    public function scopeSearch($query, $search)
    {
        if ($search) {
            $query->where('sku', 'like', '%' . $search . '%')
                ->orWhere('name', 'like', '%' . $search . '%');
        }
        return $query;
    }

    ################################################################################################################
    ## GETTERS E MUTATORS
    ################################################################################################################
    public function setSkuAttribute($value)
    {
        $this->attributes['sku'] = strtoupper($value);
    }
}
