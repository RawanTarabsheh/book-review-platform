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
    public static function getRivews($api_id = null)
    {
        $user = Auth::user();
        $userId = $user->id;
        if ($api_id !== null)
            $book_reviews = Book::where('api_id', $api_id)
                ->with(['reviews' => function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }])->whereHas('reviews', function ($query) use ($user) {
                    $query->where('user_id', $user->id)->latest();
                })->first();
        else
            $book_reviews = Book::with(['reviews' => function ($query) use ($userId) {
                $query->where('user_id', $userId);
            }])->whereHas('reviews', function ($query) use ($user) {
                $query->where('user_id', $user->id)->latest();
            })->paginate(2);
        return $book_reviews;
    }
}
