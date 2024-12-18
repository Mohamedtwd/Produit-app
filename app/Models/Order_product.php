<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Order_product extends Pivot
{
    protected $table = 'order_product';

    protected $fillable = ['order_id', 'product_id', 'Quantité', 'prix'];
}
