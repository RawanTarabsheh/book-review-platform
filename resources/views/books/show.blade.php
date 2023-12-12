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
                    <div>
                        <form action="{{ route('books.submitReview', $id) }}" method="post">
                            @csrf
                            <label for="rating">Rating:</label>
                            <input type="number" name="rating" min="1" max="5" required>

                            <label for="comment">Comment:</label>
                            <textarea name="comment" required></textarea>

                            <button type="submit">Submit Review</button>
                        </form>

                        <form action="{{ route('books.rateBook', $id) }}" method="post">
                            @csrf
                            <label for="rating">Rate the Book:</label>
                            <input type="number" name="rating" min="1" max="5" required>

                            <button type="submit">Rate</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
