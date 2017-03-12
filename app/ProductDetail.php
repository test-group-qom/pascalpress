<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;

class ProductDetail extends Model
{
     protected  $fillable = ['config','descriptions','spesefication','language'];

protected $casts = [
    'config' => 'array',
    'descriptions' => 'array',
    'spesefication' => 'array',

];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
