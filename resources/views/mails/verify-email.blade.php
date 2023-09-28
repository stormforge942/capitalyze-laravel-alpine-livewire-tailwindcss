@php

$title = 'Welcome to Capitalyze';

$greet = "Hi {$user->firstName},";

@endphp

@extends('mails.layout')

@section('content')
<table cellspacing="0" cellpadding="0" width="100%" style="width: 100%">
    <tr>
        <td>
            <p style="
                font-family: 'Inter', Arial, sans-serif;
                font-size: 14px;
                color: #121a0f;
                line-height: 24px;
                letter-spacing: 0.07px;
                padding: 0;
                margin: 0;
            ">
                Thank you for signing up. Click the link below to confirm your email to successfully join the waitlist.
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 16px">
            <p style="
                font-family: 'Inter', Arial, sans-serif;
                font-size: 14px;
                color: #121a0f;
                line-height: 24px;
                letter-spacing: 0.07px;
                padding: 0;
                margin: 0;
                text-align: center;
            ">
                Click to verify your email address
            </p>

            <p style="
                padding-top: 24px;
                text-align: center;
            ">
                @include('mails.partials.button', [
                'text' => 'Confirm Email',
                'url' => $url ?? '#'
                ])
            </p>
        </td>
    </tr>
</table>
@endsection