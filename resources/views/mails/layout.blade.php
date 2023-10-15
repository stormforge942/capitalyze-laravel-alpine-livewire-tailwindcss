<!DOCTYPE html
    PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
    <meta charset="UTF-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta name="x-apple-disable-message-reformatting" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta content="telephone=no" name="format-detection" />
    <title>Capitalyze</title>
    <!--[if (mso 16)]>
        <style type="text/css">
            a {
                text-decoration: none;
            }
        </style>
    <![endif]-->

    <!--[if gte mso 9]>
        <style>
            sup {
                font-size: 100% !important;
            }
        </style>
    <![endif]-->

    <!--[if gte mso 9]>
        <xml>
            <o:OfficeDocumentSettings>
                <o:AllowPNG></o:AllowPNG>
                <o:PixelsPerInch>96</o:PixelsPerInch>
            </o:OfficeDocumentSettings>
        </xml>
    <![endif]-->

    <!--[if !mso]><!-->
    <style>
        @media screen and (min-width: 500px) {
            .container {
                padding-left: 48px !important;
                padding-right: 48px !important;
            }
        }
    </style>

    <link href="https://fonts.googleapis.com/css?family=Inter:400,500,600,700" rel="stylesheet" />
    <!--<![endif]-->
</head>

<body style="padding: 10px 0; margin: 0; width: 100%; background: #F4F3F6;">
    <table cellspacing="0" cellpadding="0" width="100%" align="center" style="max-width: 600px;">
        <!-- header -->
        <tr>
            <td style="padding: 0 30px; background: #fff;" class="container">
                <table cellspacing="0" cellpadding="0" width="100%" style="width: 100%;">
                    <tr>
                        <td style="padding: 32px 0; text-align: center">
                            <a href="{{ url('/') }}">
                                <img src="{{ asset('img/logo.png') }}" alt="Capitalyze logo" height="32"
                                    style="height: 32px;" />
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-top: 16px 0; text-align: center">
                            <h1 style="
                                font-family: 'Inter', Arial, sans-serif;
                                font-size: 24px;
                                font-weight: bold;
                                color: #121a0f;
                                line-height: 40px;
                                letter-spacing: -0.5px;
                                padding: 0;
                                margin: 0;
                            ">
                                {!! $title !!}
                            </h1>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <!-- header end -->

        <!-- body -->
        <tr>
            <td style="padding: 24px 30px 48px 30px; background: #fff;" class="container">
                @yield('content')
            </td>
        </tr>

        <!-- body end -->

        <tr class="footer">
            <td>
                <table cellspacing="0" cellpadding="0" width="100%" style="width: 100%">
                    <tr>
                        <td style="
                                background-color: #52d3a2;
                                padding: 40px 30px;
                            " class="container">
                            <table cellspacing="0" cellpadding="0" width="100%" style="width: 100%">
                                <tr>
                                    <td style="
                                        text-align: center;
                                    ">
                                        <p style="
                                            font-family: 'Inter', Arial,
                                                sans-serif;
                                            font-size: 14px;
                                            color: #121a0f;
                                            line-height: 16px;
                                            font-weight: 700;
                                            padding: 0;
                                            margin: 0;
                                        ">
                                            Follow us
                                        </p>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" width="100%" style="width: 100%">
                                            <tr>
                                                <td width="50%" style="text-align: right; padding-right: 12px;">
                                                    <a href="https://twitter.com/capitalyzeinc" target="_blank">
                                                        <img src="{{ asset('img/twitter.png') }}"
                                                            style="height: 40px; width: 40px; border-radius: 50%; "
                                                            alt="twitter logo">
                                                    </a>
                                                </td>
                                                <td width="50%" style="text-align: left; padding-left: 12px;">
                                                    <a href="https://www.linkedin.com/company/capitalyzeinc"
                                                        target="_blank">
                                                        <img src="{{ asset('img/linkedin.png') }}"
                                                            style="height: 40px; width: 40px; border-radius: 50%; "
                                                            alt="linkedin logo">
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="text-align: center; padding-top: 24px;">
                                        <p style="
                                            font-family: 'Inter', Arial,
                                                sans-serif;
                                            font-size: 12px;
                                            color: #121a0f;
                                            line-height: 16px;
                                            padding: 0;
                                            margin: 0;
                                        ">
                                            Los Angeles, California, USA
                                        </p>
                                    </td>
                                </tr>

                                {{-- <tr>
                                    <td style="text-align: center; padding-top: 24px;">
                                        <p style="
                                        font-family: 'Inter', Arial,
                                            sans-serif;
                                        font-size: 10px;
                                        color: #fff;
                                        line-height: 16px;
                                        padding: 0;
                                        margin: 0;
                                    ">
                                            If you no longer want to receive email from us, you can
                                            <a href="#" style="color: #3561E7; text-decoration: none;">
                                                Unsubscribe
                                            </a>
                                        </p>
                                    </td>
                                </tr> --}}
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>