<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    // Define the $fillable property to allow mass assignment
    protected $fillable = ['name', 'slug', 'state'];
}

