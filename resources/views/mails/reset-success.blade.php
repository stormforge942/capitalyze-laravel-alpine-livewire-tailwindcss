@php

$title = "Password reset successful";

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
                line-height: 32px;
                letter-spacing: 0.07px;
                padding: 0;
                margin: 0;
                text-align: center;
            ">
                Login to continue using Capitalyze
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 30px; text-align: center;">
            <p style="margin: 0; padding: 0;">
                @include('mails.partials.button', [
                'text' => 'Login',
                'link' => route('login')
                ])
            </p>
        </td>
    </tr>
</table>
@endsection

