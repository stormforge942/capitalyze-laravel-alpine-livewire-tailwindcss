@extends('layouts.auth')

@section('title', 'Forgot Password')

@section('content')

    @include('partials.auth-header', [
        'title' => 'Forgot Password',
    ])

    <form class="mt-4" method="post" action="{{ route('password.email') }}" autocomplete="on">
        @csrf

        @include('partials.input', [
            'type' => 'email',
            'label' => 'Email',
            'name' => 'email',
            'required' => true,
            'autofocus' => true,
            'attrs' => ['autocomplete' => 'email'],
        ])

        <div class="mt-6 text-center">
            @include('partials.green-button', [
                'text' => 'Forgot password',
                'type' => 'submit',
            ])
        </div>
    </form>
@endsection
