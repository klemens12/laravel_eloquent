<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Session;
use DB;


class Cart extends Model
{
    use HasFactory;
    
    protected $fillable = ["session_id", "product_id", "price", "quantity"];
    
    public function products(){
        return $this->hasMany('App\Models\Product');//1 to many
    }
    
    public static function get() {
        return self::where(["session_id" => session()->getId()]);
    }
    
    public static function count() {
        return self::where(["session_id" => session()->getId()])->sum("quantity");
    }
    
    public static function add($product_id, $quantity) {
        $product = Product::findOrFail($product_id);
        
        /*if($cart = self::where(["session_id" => session()->getId(), "product_id" => $product->id])->first()){
            $cart->quantity += $quantity;
            $cart->save();
        } else{
            $cart = self::create([
                "session_id" => session()->getId(),
                "product_id" => $product->id,
                "quantity" => $quantity,
                "price" => $product->price
            ]);
        }*/
        
        $cart = self::where(["session_id" => session()->getId(), "product_id" => $product->id])->first();
        $cart ? ($cart->quantity += $quantity) && $cart->save() : $cart = self::create([
                            "session_id" => session()->getId(),
                            "product_id" => $product->id,
                            "quantity" => $quantity,
                            "price" => $product->price
        ]);

        //return $cart->quantity;
        return self::count();
    }
    
    public static function quantity($id, $quantity) {
        if($quantity <= 0){
            return self::remove($id);
        }
        
        $cart = self::findOrFail($id);
        
        $cart->quantity = $quantity;
        $cart->save();
        
        return $cart;
    }
    
    public static function remove($id) {
        return self::destroy($id);
    }
    
    public static function flush() {
        return self::where(["session_id" => session()->getId()])->delete();
    }
    
    public static function total() {
        return round(self::where(["session_id" => session()->getId()])->get()->map(function($item){
            return $item->price * $item->quantity;
        })->sum(), 2);
    }
    
    public static function loadProducts() {
        $cart_products = self::get()->select('id', 'product_id', 'price', 'quantity')->get();
        $cart_products_id = $cart_products->pluck('product_id');
        $originalProducts = collect(Product::whereIn('id', $cart_products_id)->select('id', 'product_name', 'product_url')->get())->keyBy('id');
        
        $i = 0;
        
        $final = [];
        foreach($cart_products as $cart_item){
            $final[$i]['cart_item'] = $cart_item;
            $final[$i]['cart_item']['item_total'] = $cart_item->price;
            
            $final[$i]['orig_product'] = $originalProducts[$cart_item->product_id];
            $final[$i]['orig_product']['sef'] = route('product.product', $final[$i]['orig_product']['product_url']);
            
            $i++;
        }
        
        
        return $final;
    }

    public static function updateQuantity($product_id, $quantity) {
        if($cart = self::where(["session_id" => session()->getId(), "product_id" => $product_id])->first()){
            $cart->quantity = $quantity;
            $cart->save();
        }
    }
    
    /*
     * Delete unused cart items
     */
    public static function removeInactiveItems() {
        $sessions_id = DB::table('sessions')->select('id')->get()->pluck('id')->toArray();
      
        if($carts = self::whereNotIn("session_id", $sessions_id)->select('id')->get()){
          
            foreach($carts as $item){
                self::remove($item['id']);
            }
        }
       
    }
}
