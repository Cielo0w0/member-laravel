<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = ['product_name', 'price','discript','product_type_id'];

    public function type(){
        return $this->belongsTo(ProductType::class,'product_type_id');
        // =return $this->belongsTo('App\ProductType');
    }

    public function photos(){
        return $this->hasMany(ProductImg::class,'product_id');
    }
}
