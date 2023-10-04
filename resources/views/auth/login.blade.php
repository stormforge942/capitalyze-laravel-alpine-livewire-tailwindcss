@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
@include('partials.auth-header', ['title' => 'Sign In', 'badge' => true])
<form class="mt-4" method="post" action="{{ route('login') }}">
    @csrf

    @include('partials.input', [
    'type' => 'email',
    'label' => 'Work Email',
    'name' => 'email',
    'required' => true,
    'autofocus' => true,
    ])

    @include('partials.input', [
    'type' => 'password',
    'class' => 'mt-6',
    'label' => 'Password',
    'name' => 'password',
    ])

    <div class="mt-4 flex justify-between items-center text-sm">
        <label class="flex items-center gap-1.5">
            <input type="checkbox" class="text-black border-2 border-black h-4 w-4 rounded-sm focus:ring-black"
                name="remember">
            <span>Remember Me</span>
        </label>
        <a href="{{ route('password.request') }}">Forgot Password?</a>
    </div>

    <div class="mt-6 text-center">
        @include('partials.green-button', ['text' => 'Sign In', 'type' => 'submit'])

        <a href="{{ route('waitlist.join') }}" class="mt-4 inline-block">
            Don't have an account? <span class="font-semibold">Join the waitlist</span>
        </a>
    </div>
</form>
@endsection