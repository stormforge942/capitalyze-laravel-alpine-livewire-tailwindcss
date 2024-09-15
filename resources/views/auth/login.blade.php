@extends('layouts.auth')

@section('title', 'Sign In')

@section('content')
    @include('partials.auth-header', ['title' => 'Sign In', 'badge' => true])

    @if ($errors->count())
        <div class="text-center text-danger mt-4">
            Email or password is incorrect
        </div>
    @endif

    <form class="mt-4" method="post" action="{{ route('login') }}" autocomplete="on">
        @csrf

        @include('partials.input', [
            'type' => 'email',
            'label' => 'Email',
            'class' => $errors->count() ? 'border-danger' : '',
            'name' => 'email',
            'required' => true,
            'autofocus' => $errors->count() ? false : true,
            'attrs' => ['autocomplete' => 'email'],
            'showError' => false,
        ])

        @include('partials.input', [
            'type' => 'password',
            'class' => 'mt-6' . ($errors->count() ? ' border-danger' : ''),
            'label' => 'Password',
            'name' => 'password',
            'required' => true,
            'attrs' => ['autocomplete' => 'current-password'],
            'toggle' => true,
            'showError' => false,
        ])

        <div class="mt-4 flex justify-between items-center text-sm">
            <label class="flex items-center gap-1.5">
                <input type="checkbox" value="on" class="text-black border-2 border-black h-4 w-4 rounded-sm focus:ring-black"
                    name="remember" @if (old('remember') == 'on') checked @endif>
                <span>Remember Me</span>
            </label>
            <a href="{{ route('password.request') }}" class="hover:underline">Forgot Password?</a>
        </div>

        <div class="mt-6 text-center">
            @include('partials.green-button', [
                'text' => 'Sign In',
                'type' => 'submit',
            ])

            <div class="mt-6 inline-block">
                Don't have an account? <a href="{{ route('waitlist.join') }}"
                    class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Join the
                    waitlist</a>
            </div>

            <div class="mt-4 mb-2 inline-block text-[#DA680B]">
                Don’t have a password? <a href="{{ route('invited-auth.verify-email') }}"
                    class="font-semibold underline hover:bg-green-light2 rounded p-1 -mx-0.5 transition-all">Create
                    Password</a>
            </div>
        </div>
    </form>
@endsection
