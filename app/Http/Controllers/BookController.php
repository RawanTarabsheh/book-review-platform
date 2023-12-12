<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class BookController extends Controller
{
    public function index()
    {
        // Make a request to the Google Books API to get a list of books
        $response = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'laravel',
        ]);
        $books = $response->json()['items'];
        // dd($books);
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

        return view('books.index', compact('books'));
    }

    public function show($api_id)
    {
        // dd($id);
        // Make a request to the Google Books API to get details of a specific book
        $response = Http::get("https://www.googleapis.com/books/v1/volumes/{$api_id}");

        $book = $response->json();
        $book_info=Book::where('api_id',$api_id)->first();
        $id=$book_info->id;
        return view('books.show', compact('book','id'));
    }

    // public function show($id)
    // {
    //     $book = Book::findOrFail($id);
    //     return view('books.show', compact('book'));
    // }

    public function submitReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        $user = Auth::user();

        $review = new Review([
            'user_id' => $user->id,
            'book_id' => $id,
            'rating' => $request->input('rating'),
            'comment' => $request->input('comment'),
        ]);

        $review->save();

        return redirect()->route('books.show', $id)->with('success', 'Review submitted successfully.');
    }

    public function rateBook(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        $user = Auth::user();

        // Update the book's rating logic
        $book = Book::findOrFail($id);
        $book->rating = $request->input('rating');
        $book->save();

        return redirect()->route('books.show', $id)->with('success', 'Rating updated successfully.');
    }

    public function userHistory()
    {
        $user = Auth::user();
        $reviews = $user->reviews()->with('book')->latest()->get();
        return view('user.history', compact('reviews'));
    }
}
