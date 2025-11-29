<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPostTag extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = ['blog_post_id', 'blog_tag_id'];

    public function post() {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function tag() {
        return $this->belongsTo(BlogTag::class, 'blog_tag_id');
    }
}
