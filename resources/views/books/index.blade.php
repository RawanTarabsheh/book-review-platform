@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Book List') }}</div>

                <div class="card-body">
                    @foreach ($books as $book)
                        <div>
                            <h2>{{ $book['volumeInfo']['title'] }}</h2>
                            <p>Authors: {{ implode(', ', $book['volumeInfo']['authors']) }}</p>
                            <p>Published Date: {{ $book['volumeInfo']['publishedDate'] }}</p>
                            <p>Description: {{ $book['volumeInfo']['description'] }}</p>
                            <a href="{{ route('books.show', $book['id']) }}">View Details</a>
                            <hr>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
