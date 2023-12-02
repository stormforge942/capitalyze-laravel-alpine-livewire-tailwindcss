@extends('errors.layout')

@section('content')

    <div class="container">
        <h1>Ticker Not Found</h1>
        <p>The ticker '{{ $ticker }}' could not be found in our database.</p>
    </div>

    <form action="{{ route('home') }}" method="GET" class="mt-6 md:mt-8">
        @include('partials.green-button', [
            'text' => 'Go Home',
            'type' => 'submit',
        ])
    </form>
@endsection
