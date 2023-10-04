@extends('layouts.auth')

@section('title', 'Reset password')

@section('content')

@include('partials.auth-header', [
'title' => 'Password created successfully',
])

<form action="{{ route('login') }}" method="GET">
    <svg class="mt-4 mx-auto" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80" fill="none">
        <path
            d="M40.0013 73.3333C21.5918 73.3333 6.66797 58.4093 6.66797 40C6.66797 21.5905 21.5918 6.66663 40.0013 6.66663C58.4106 6.66663 73.3346 21.5905 73.3346 40C73.3346 58.4093 58.4106 73.3333 40.0013 73.3333ZM36.6766 53.3333L60.247 29.7631L55.533 25.049L36.6766 43.9053L27.2487 34.477L22.5346 39.1913L36.6766 53.3333Z"
            fill="#52D3A2" />
    </svg>

    <p class="mt-4 leading-7 text-md text-center">Sign in to continue using Capitalyze</p>

    <div class="mt-4 text-center">
        @include('partials.green-button', [
        'text' => 'Sign In',
        'type' => 'submit',
        ])
    </div>
</form>

@endsection