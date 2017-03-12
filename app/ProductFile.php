<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductFile extends Model
{
    use SoftDeletes;
    protected $fillable = ['type', 'path','product_id'];


    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
