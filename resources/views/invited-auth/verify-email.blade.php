@extends('layouts.auth')

@section('title', 'Verify Email')

@section('content')
    <div>
        @livewire('invited-auth.verify-email')
    </div>
@endsection
