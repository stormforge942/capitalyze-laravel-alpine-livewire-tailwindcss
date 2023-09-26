@php

$title = 'Welcome to the Future of Financial Data';

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
                Thank you for requesting an invite to Capitalyze! You have successfully joined the waitlist.<br><br>
                We can't wait to have you onboard soon and share what we have been working on!<br><br>
                Best,<br>
                Team Capitalyze
            </p>
        </td>
    </tr>
</table>
@endsection