<?php

namespace App\Http\Controllers\web;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\QueryException;

class BookController extends Controller
{
    public function index()
    {
        // Make a request to the Google Books API to get a list of books
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'laravel',
        ]);
        $books = $response->json()['items'];
        foreach ($books as $book) {
            $api_id = $book['id'];
            $data = [
                'title' => $book['volumeInfo']['title'],
                'api_id' => $api_id,
                'author' =>  implode(', ', $book['volumeInfo']['authors']),
                'published_date' => $book['volumeInfo']['publishedDate'],
                'description' => $book['volumeInfo']['description'],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),

            ];

            Book::insertOrUpdate($api_id, $data);
        }

        return view('web.books.index', compact('books'));
    }

    public function show($api_id)
    {
        // Make a request to the Google Books API to get details of a specific book
        $response = Http::get("https://www.googleapis.com/books/v1/volumes/{$api_id}");
        $book = $response->json();
        $book_info = Book::where('api_id', $api_id)->with('reviews')->first();
        $book_reviews = Book::getRivews($api_id);
        return view('web.books.show', compact('book', 'book_info', 'book_reviews'));
    }

    public function history()
    {
        $reviews = Book::getRivews(null);
        return view('web.books.history', compact('reviews'));
    }

    public function submitReview(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $request->validate([
                'rating' => 'required|integer|between:1,5',
                'comment' => 'required|string',
                'api_id' => 'string'
            ]);

            $user = Auth::user();
            $api_id = $request->input('api_id');
            $review = new Review([
                'user_id' => $user->id,
                'book_id' => $id,
                'rating' => $request->input('rating'),
                'comment' => $request->input('comment'),
            ]);

            $review->save();
            DB::commit();
            return redirect()->route('books.show', $api_id)->with('success', 'Review submitted successfully.');
        } catch (QueryException $e) {
            DB::rollback();
            return response()->json(['error' => 'Something worng.']);
        }
    }
}
