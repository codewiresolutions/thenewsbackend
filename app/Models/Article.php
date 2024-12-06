<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image',
        'video',
        'author_id',
    ];

    // Define the relationship with the Author model
    public function author()
    {
        return $this->belongsTo(Author::class);
    }
}
