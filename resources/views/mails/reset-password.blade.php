@php

$title = "Reset password";

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
                We noticed you requested to reset your password. Click the link below to reset your password.
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
                Click to reset your password
            </p>

            <p style="
                padding-top: 24px;
                text-align: center;
            ">
                @include('mails.partials.button', [
                'text' => 'Reset Password',
                'url' => $url ?? '#'
                ])
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 22px;">
            <p style="
                font-family: 'Inter', Arial, sans-serif;
                font-size: 14px;
                color: #121a0f;
                line-height: 24px;
                letter-spacing: 0.07px;
                padding: 0;
                margin: 0;
            ">
                If you don’t use this link within 3 hours, it will expire. To get a new password reset link, visit:
                <a href="{{ url(route('password.request')) }}" style="
                    font-family: 'Inter', Arial, sans-serif;
                    font-size: 14px;
                    color: #3561e7;
                    text-decoration: underline;
                    padding: 0;
                    margin: 0;
                ">
                    {{ url(route('password.request')) }}
                </a>
            </p>
        </td>
    </tr>
</table>
@endsection