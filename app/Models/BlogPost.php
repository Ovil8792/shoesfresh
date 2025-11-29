<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'slug', 'content', 'thumbnail', 'status', 'published_at', 'blog_category_id'];

    public function blogPostTags() {
    return $this->hasMany(BlogPostTag::class);
}

    public function blogCategory() {
        return $this->belongsTo(BlogCategory::class);
    }

}
