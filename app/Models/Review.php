<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'book_id',
        'rating',
        'comment',
    ];

    // Define a relationship with the User model if reviews are associated with users
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define a relationship with the Book model
    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
