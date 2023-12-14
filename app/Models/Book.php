<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'api_id',
        'title',
        'author',
        'published_date',
        'description',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
    public static function insertOrUpdate($api_id,$data){
        self::updateOrInsert(
            ['api_id' => $api_id],
           $data
        );
        return true;


    }
    public static function getRivews($api_id=null){
        $user = Auth::user();
        if($api_id !== null)
        $book_reviews = Book::where('api_id', $api_id)
            ->whereHas('reviews', function ($query) use ($user) {
                $query->where('user_id', $user->id)->latest();
            })
            ->with('reviews')
            ->first();
            else
            $book_reviews = Book::whereHas('reviews', function ($query) use ($user) {
                $query->where('user_id', $user->id)->latest();
            })
            ->with('reviews')
            ->paginate(2);
            return $book_reviews;
    }
}
