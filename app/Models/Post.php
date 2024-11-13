<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Specify which fields are mass assignable
    protected $fillable = [
        'title',    // Title of the post
        'content',  // Content of the post
        'category', // Category of the post
        'slug',     // Slug for URL
        'author',   // Author of the post
        'image',    // Image URL or file path
    ];
}
