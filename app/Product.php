<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Category;
use App\ProductDetail;
use App\ProductFile;


class Product extends Model
{
    protected  $fillable = ['title'];

protected $casts = [
    'title' => 'array',
];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

      public function productDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }
      public function productFiles()
    {
        return $this->hasMany(ProductFile::class);
    }
}
