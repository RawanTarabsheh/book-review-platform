@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Book Details') }}</div>

                    <div class="card-body">
                        <h2>{{ $book['volumeInfo']['title'] }}</h2>
                        <p>Authors: {{ implode(', ', $book['volumeInfo']['authors']) }}</p>
                        <p>Published Date: {{ $book['volumeInfo']['publishedDate'] }}</p>
                        <p>Description: {{ $book['volumeInfo']['description'] }}</p>
                        @if (isset($book['volumeInfo']['categories']))
                            <p>Categories: {{ implode(', ', $book['volumeInfo']['categories']) }}</p>
                        @else
                            <p>Categories: N/A</p>
                        @endif
                        <p>Page Count: {{ $book['volumeInfo']['pageCount'] }}</p>
                        <p>Language: {{ $book['volumeInfo']['language'] }}</p>
                        <p>Preview Link: <a href="{{ $book['volumeInfo']['previewLink'] }}" target="_blank">Preview</a></p>

                        <a href="{{ route('books.index') }}">Back to Book List</a>
                    </div>
                    <div class="reviews">
                        <h1 class="title">Your Review History</h1>
                
                        @if (isset($book_reviews->reviews) && $book_reviews->reviews->count() > 0)
                            <div class="review-list">
                                @foreach ($book_reviews->reviews as $review)
                                    <div class="review-item">
                                        <h3>{{ $review->book->title }}</h3>
                                        <p>Rating: {{ $review->rating }}</p>
                                        <p>Comment: {{ $review->comment }}</p>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p>No reviews found. Start reviewing books!</p>
                        @endif
                    </div>

                    <div class="review_form">

                        <form action="{{ route('books.submitReview', $book_info->id) }}" method="post">
                            @csrf
                            <div class="title">Submit your Review & Rate for this book</div>
                            <input type="text" value="{{  $book_info->api_id}}" name="api_id" hidden/>
                            <label for="rating">Rating:</label>
                            <input type="number" name="rating" min="1" max="5" placeholder="Choose Rate" >

                            <label for="comment">Comment:</label>
                            <textarea name="comment" placeholder="Add your comment ...."></textarea>

                            <button type="submit">Submit Review</button>
                        </form>
         
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
