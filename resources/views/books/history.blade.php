@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Book List') }}</div>

                    <div class="card-body">
                        <!-- Display user's review history -->

                        @foreach ($reviews as $review)
                            <div>
                                <h3>{{ $review->book->title }}</h3>
                                <p>Rating: {{ $review->rating }}</p>
                                <p>Comment: {{ $review->comment }}</p>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
