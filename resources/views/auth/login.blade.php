@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    @include('partials.auth-header', ['title' => 'Sign In', 'badge' => true])
    <form class="mt-4" method="post" action="{{ route('login') }}" autocomplete="on">
        @csrf

        @include('partials.input', [
            'type' => 'email',
            'label' => 'Email',
            'name' => 'email',
            'required' => true,
            'autofocus' => true,
            'attrs' => ['autocomplete' => 'email'],
        ])

        @include('partials.input', [
            'type' => 'password',
            'class' => 'mt-6',
            'label' => 'Password',
            'name' => 'password',
            'required' => true,
            'attrs' => ['autocomplete' => 'current-password'],
            'toggle' => true,
        ])

        <div class="mt-4 flex justify-between items-center text-sm">
            <label class="flex items-center gap-1.5">
                <input type="checkbox" class="text-black border-2 border-black h-4 w-4 rounded-sm focus:ring-black"
                    name="remember" :checked="{{ old('remember') == 'on' }}">
                <span>Remember Me</span>
            </label>
            <a href="{{ route('password.request') }}" class="hover:underline">Forgot Password?</a>
        </div>

        <div class="mt-6 text-center">
            @include('partials.green-button', [
                'text' => 'Sign In',
                'type' => 'submit',
            ])

            <div class="mt-4 inline-block">
                Don't have an account? <a href="{{ route('waitlist.join') }}" class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Join the
                    waitlist</a>
            </div>
        </div>
    </form>
@endsection
