@php

$title = $invitation->team->name . ' has invited you';

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
                Hi,<br><br>
                We are excited to have you join <b>{{ $invitation->team->name }}</b> and contribute to making financial decisions. Please accept invite.
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
                font-weight: 500;
            ">
                <b>
                    To get started, click on the link below to accept the invitation.
                </b>
            </p>

            <p style="
                padding-top: 24px;
                text-align: center;
            ">
                @include('mails.partials.button', [
                    'text' => 'Accept Invite',
                    'url' => $url,
                ])
            </p>

            <p style="
                font-family: 'Inter', Arial, sans-serif;
                font-size: 14px;
                color: #121a0f;
                line-height: 24px;
                letter-spacing: 0.07px;
                padding: 0;
                margin: 0;
                text-align: center;
                padding-top: 24px;
            ">
                If you have any issues, please contact your admin
            </p>
        </td>
    </tr>
</table>
@endsection