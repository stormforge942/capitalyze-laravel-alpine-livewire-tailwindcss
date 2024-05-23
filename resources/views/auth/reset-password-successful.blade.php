@extends('layouts.auth')

<?php $createFlow = ($flow ?? '') === 'create-password'; ?>

@section('title', $createFlow ? 'Create' : 'Reset' . ' Password Successful')

@section('content')
    @if (!$user->is_approved)
        <div class="text-center py-4">
            <h1 class="text-2xl font-semibold">Your email has been verified</h1>

            <p class="mt-5 text-[#DA680B] font-medium">
                We’ll send you an email once your account has been approved to access <span class="text-black">Capitalyze</span>
            </p>
        </div>
    @else
        <div class="text-center">
            <p class="leading-10 font-medium text-lg text-center">
                Password {{ $createFlow ? 'created' : 'reset' }} successfully
            </p>

            <form action="{{ route('login') }}" method="GET">
                <svg class="mt-4 mx-auto" xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 80 80"
                     fill="none">
                    <path
                        d="M40.0013 73.3333C21.5918 73.3333 6.66797 58.4093 6.66797 40C6.66797 21.5905 21.5918 6.66663 40.0013 6.66663C58.4106 6.66663 73.3346 21.5905 73.3346 40C73.3346 58.4093 58.4106 73.3333 40.0013 73.3333ZM36.6766 53.3333L60.247 29.7631L55.533 25.049L36.6766 43.9053L27.2487 34.477L22.5346 39.1913L36.6766 53.3333Z"
                        fill="#52D3A2" />
                </svg>

                <p class="mt-4 leading-7 text-md text-center">Sign in to continue using <span class="text-black">Capitalyze</span></p>

                <div class="mt-4 text-center">
                    @include('partials.green-button', [
                        'text' => 'Sign In',
                        'type' => 'submit',
                    ])
                </div>
            </form>
        </div>
    @endif
@endsection
