<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Product;

class Category extends Model
{
    use HasFactory;
    
    public function user(){
        return $this->belongsTo('App\Models\User');//two-way communication with users table
    }
    
    public function products(){
        return $this->belongsToMany('App\Models\Product', 'category_product', 'category_id', 'product_id');
    }
}
