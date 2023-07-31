<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\User;
use App\Models\Order;
use App\Models\Media;
use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class Product extends Model
{
    use HasFactory;
    protected $fillable = ['price'];
    
    public function categories(){
        return $this->belongsToMany('App\Models\Category');
    }
    
    public function user(){
        return $this->belongsTo('App\Models\User');//two-way communication with users table
    }
    
    public function orders(){
        return $this->belongsToMany('App\Models\Order');
    }
    
    public function medias(){
        return $this->hasMany('App\Models\Media');
    }
    
    public static function getWithFilter(string $filterType, $searchPhrase, $priceFrom, $priceTo){
        $products = [];
        
        switch($filterType){
            case '-1':
                $category = Category::with([
                    'products' => function ($query) {
                  
                    }])->find(1);
                
                $products = $category->products->map(function ($product) {
                    $product->sef = route('product.product', $product->product_url);
                    $product->thumb = $product->medias[0]['url'];
                    return $product;
                });
                  return response()->json(['success' => true, 'message' => 'ok', 'products' => $products]);
            break;
            case 'price_up':
                $category = Category::with(['products' => function ($query) {
                    $query->orderBy('price', 'asc');
                }])->find(1);
                $products = $category->products->map(function ($product) {
                    $product->sef = route('product.product', $product->product_url);
                    $product->thumb = $product->medias[0]['url'];
                    return $product;
                });
                  return response()->json(['success' => true, 'message' => 'ok', 'products' => $products]);
            break;
            case 'price_down':
                $category = Category::with(['products' => function ($query) {
                    $query->orderBy('price', 'desc');
                }])->find(1);
                $products = $category->products->map(function ($product) {
                    $product->sef = route('product.product', $product->product_url);
                    $product->thumb = $product->medias[0]['url'];
                    return $product;
                });
                return response()->json(['success' => true, 'message' => 'ok', 'products' => $products]);
            break;
            case 'cat_search':
                
                $letterCount = strlen($searchPhrase);
                if ($letterCount < 3) {
                    return response()->json(['success' => false, 'message' => ['Search phrase must be contain > 3 letters']], 400);
                }
                $words = str_word_count($searchPhrase, 1);

                $minWordLength = 3;
                $filteredWords = array_filter($words, function ($word) use ($minWordLength) {
                    return mb_strlen($word) >= $minWordLength;
                });

                $category = Category::with([
                    'products' => function ($query) {
                                
                }])->find(1);
                

                $products = $category->products->map(function ($product) {


                    $product->sef = route('product.product', $product->product_url);
                    $product->thumb = $product->medias[0]['url'];
                    return $product;
                });

                $final = [];
                foreach ($products as $item) {
                    if (strpos($item->product_name, $searchPhrase) !== false) {
                        $final[] = $item;
                    }
                }

                return response()->json(['success' => true, 'message' => 'ok', 'products' => $final]);
            break;
            case 'prices':
                $category = Category::with(['products' => function ($query) {
                    $query->orderBy('price', 'asc');
                }])->find(1);
                
                $products = $category->products->map(function ($product) {
                 
                    $product->sef = route('product.product', $product->product_url);
                    $product->thumb = $product->medias[0]['url'];
                    return $product;
                    
                });
                $final = [];
                foreach ($products as $product) {
                      if($product->price >= $priceFrom && $product->price <= $priceTo){
                        $final[] = $product;
                    }
                }
                return response()->json(['success' => true, 'message' => 'ok', 'products' => $final]);
            break;
            default:
                return response()->json(['success' => true, 'message' => 'ok', 'products' => []]);
            break;
                
        }
        
        return $products;
    }
}
