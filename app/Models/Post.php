<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    // Fillable attributes for mass assignment
    // app/Models/Post.php
protected $fillable = ['title', 'category_id', 'description', 'image', 'video', 'status'];


    // Relationship to Category (assuming you have a Category model)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
