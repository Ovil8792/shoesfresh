<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [];

    /**
     * A product belongs to a category.
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'product_id');
    }
}
