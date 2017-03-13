<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use SoftDeletes;
    protected $fillable = ['config', 'descriptions', 'spesefication', 'language','product_id'];

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
