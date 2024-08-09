@extends('layouts.auth')

@section('title', 'Two Step Verification')

@section('content')
    @include('partials.auth-header', ['title' => 'Enter Code', 'badge' => true])
    
    <form class="mt-4" method="POST" action="{{ route('2fa.store') }}">
        @csrf

        @include('partials.input', [
            'type' => 'text',
            'label' => 'Two-Factor Code',
            'class' => $errors->count() ? 'border-danger' : '',
            'name' => 'code',
            'required' => true,
            'autofocus' => $errors->count() ? false : true,
            'showError' => true,
        ])

        <div class="mt-6 text-center">
            @include('partials.green-button', [
                'text' => 'Verify',
                'type' => 'submit',
            ])
        </div>
    </form>

    <form method="POST" action="{{ route('2fa.resend') }}" class="mt-2 text-center">
        @csrf
        <span>If you didn't receive any code yet</span> <button class="text-blue hover:underline" type="submit">Resend Code</button>
    </form>
@endsection
