@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message', __('Page Expired'))
@section('description')
It seems you had left this tab inactive for some time, please go <a href="{{ url()->previous()  }}" style="color: un; text-decoration: underline">back</a> and try again.
@endsection
