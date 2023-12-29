@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}

                    <div>
                        <a href="{{ route('books.index') }}" class="tab">{{ __('Show Books') }}</a>

                        <a href="{{ route('books.history') }}" class="tab">{{ __('Your history ') }}</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
