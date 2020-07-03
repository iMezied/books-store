<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Product
 * @package App
 */
class Product extends Model
{
    /**
     * @var array
     */
    protected $guarded = [];

    /**
     * Define the relation between products and sales
     * @return HasMany
     */
    public function sales()
    {
        return $this->hasMany(Sale::class, 'product_id');
    }
}
