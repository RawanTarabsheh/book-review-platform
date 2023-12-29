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
                                <h5>{{__('Book Title :') }}<span>{{ $review->title }}</span></h5>

                                @foreach ($review->reviews as $review)
                                <div class="review-item">
                                    <p class="p-0 m-0">Rating: {{ $review->rating }}</p>
                                    <p class="p-0 m-0">Comment: {{ $review->comment }}</p>
                                    <p class="p-0 m-0">since: {{ $review->created_at->diffForHumans() }}</p>

                                </div>
                            @endforeach

                            </div>
                        @endforeach
                        <div>
                            {{ $reviews->appends(app('request')->input())->links('vendor.pagination.bootstrap-5') }}

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
