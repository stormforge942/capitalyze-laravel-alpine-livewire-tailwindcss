@php

$title = 'Welcome to the Future of Financial Data';

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
                Thank you for requesting an invite to Capitalyze! You have successfully joined the waitlist.<br><br>
                We can't wait to have you onboard soon and share what we have been working on!
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
            ">
                &bull;
                <a href="#" target="_blank" style="
                            color: #3561e7;
                            text-decoration: none;
                        ">Financials:</a>
                “as presented” financials on 50,000+
                companies globally
                <br />

                &bull;
                <a href="#" target="_blank" style="
                            color: #3561e7;
                            text-decoration: none;
                        ">Analysis:</a>
                revenue, efficiency, capital allocation,
                management analysis
                <br />

                &bull;
                <a href="#" target="_blank" style="
                            color: #3561e7;
                            text-decoration: none;
                        ">Filings:</a>
                one-click functionality from financial table
                to company filing
                <br />

                &bull;
                <a href="#" target="_blank" style="
                    color: #3561e7;
                    text-decoration: none;
                ">
                    Ownership:
                </a>
                track holdings and create watchlists for
                10,000+ funds
                <br />

                &bull;
                <a href="#" target="_blank" style="
                    color: #3561e7;
                    text-decoration: none;
                ">
                    and more...
                </a>
            </p>
        </td>
    </tr>
</table>
@endsection