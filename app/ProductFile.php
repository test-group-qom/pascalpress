<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class ProductFile extends Model
{
     protected  $fillable = ['type','path'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
