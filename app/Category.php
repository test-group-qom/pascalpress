<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Product;
use Illuminate\Database\Eloquent\SoftDeletes;
class Category extends Model
{
    use SoftDeletes;

    protected  $fillable = ['title'];

    protected $casts = [
        'title' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
