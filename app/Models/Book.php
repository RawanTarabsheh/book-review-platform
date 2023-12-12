<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
