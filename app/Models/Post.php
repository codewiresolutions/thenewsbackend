<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'category_id', 'description', 'image', 'video', 'status', 'tag_id'];

    // Relationship to Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Relationship to Tags
    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
