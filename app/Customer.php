<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Customer
 * @package App
 */
class Customer extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Define the relation between customers and sales
     * @return HasMany
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id');
    }
}
