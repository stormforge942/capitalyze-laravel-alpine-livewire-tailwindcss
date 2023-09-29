@php

$title = "OTP Verification";

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
                text-align: center;
            ">
                Login to continue using Capitalyze
            </p>
        </td>
    </tr>
    <tr>
        <td style="padding-top: 16px">
            <p style="
                font-family: 'Inter', Arial, sans-serif;
                font-size: 14px;
                color: #121a0f;
                line-height: 32px;
                letter-spacing: 0.07px;
                padding: 0;
                margin: 0;
                text-align: center;
                font-weight: 500;
            ">
                Copy and paste OTP code
            </p>

            <p style="
                padding-top: 16px;
                font-family: 'Inter', Arial, sans-serif;
                font-size: 20px;
                color: #121a0f;
                line-height: 32px;
                letter-spacing: 0.07px;
                padding: 16px 0 0 0;
                margin: 0;
                text-align: center;
                font-weight: 500;
            ">
                123456
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
                text-align: center;
            ">
                If you don’t use this OTP within 15 minutes, it will expire.
            </p>
        </td>
    </tr>
</table>
@endsection