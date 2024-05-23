@extends('layouts.auth')

@section('title', 'Set Password')

@section('content')
    <div>
        @livewire('invited-auth.set-password', ['user' => $user, 'token' => $token])
    </div>
@endsection
