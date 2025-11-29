<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogCategory extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['name', 'slug', 'status'];

    public function posts() {
        return $this->hasMany(BlogPost::class);
    }
}
