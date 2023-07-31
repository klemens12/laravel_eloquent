<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Order;

class Order extends Model
{
    use HasFactory;
    
    public function products(){
        return $this->belongsToMany('App\Models\Product', 'order_product', 'order_id', 'product_id');
    }
}
