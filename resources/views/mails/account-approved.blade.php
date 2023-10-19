@php

$title = "Welcome to the Capitalyze Beta";
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
                Hi {{ $user->firstName }},<br><br>

                Thanks for hanging in there! We're so excited to finally welcome you to the Capitalyze Beta.<br><br>

                Capitalyze is the future of financial data. We can't wait to show you what we have been working
                on!<br><br>

                Best,<br>
                Team Capitalyze
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
                font-weight: 700;
            ">
                To get started, click on the link below to set up your password:
            </p>

            <p style="
                padding-top: 16px;
                text-align: center;
            ">
                @include('mails.partials.button', [
                'text' => 'Set Up Your Password',
                'url' => $url ?? '#'
                ])
            </p>
        </td>
    </tr>
</table>
@endsection