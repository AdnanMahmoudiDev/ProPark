<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>{{ __('تأیید آدرس ایمیل') }} | AvaPark</title>

    <style>
        @media only screen and (max-width: 640px) {
            .email-container {
                width: 100% !important;
            }

            .email-content {
                padding: 32px 24px !important;
            }

            .email-header {
                padding: 28px 24px !important;
            }

            .email-footer {
                padding: 24px !important;
            }

            .button {
                display: block !important;
                width: auto !important;
            }
        }
    </style>
</head>

<body class="m-0 bg-slate-100 font-sans text-slate-800">

    <!-- Background -->
    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        border="0"
        class="w-full bg-slate-100"
        style="background-color: #f1f5f9;"
    >
        <tr>
            <td
                align="center"
                class="px-4 py-10"
                style="padding: 40px 16px;"
            >

                <!-- Main Email Container -->
                <table
                    width="600"
                    cellpadding="0"
                    cellspacing="0"
                    border="0"
                    class="email-container w-full max-w-[600px] overflow-hidden rounded-xl bg-white"
                    style="
                        width: 100%;
                        max-width: 600px;
                        background-color: #ffffff;
                        border: 1px solid #e2e8f0;
                        border-radius: 12px;
                        overflow: hidden;
                    "
                >

                    <!-- Header -->
                    <tr>
                        <td
                            align="center"
                            class="email-header px-8 py-8"
                            style="
                                padding: 32px;
                                background-color: #ffffff;
                                border-bottom: 1px solid #e2e8f0;
                            "
                        >

                            <a
                                href="{{ config('app.url') }}"
                                style="
                                    text-decoration: none;
                                    color: #0f172a;
                                "
                            >
                                <span
                                    style="
                                        display: block;
                                        font-family: Arial, Tahoma, sans-serif;
                                        font-size: 27px;
                                        font-weight: 700;
                                        letter-spacing: -0.5px;
                                        color: #0f172a;
                                    "
                                >
                                    AvaPark
                                </span>
                            </a>

                        </td>
                    </tr>

                    <!-- Main Content -->
                    <tr>
                        <td
                            class="email-content px-11 py-10"
                            style="
                                padding: 44px;
                                background-color: #ffffff;
                            "
                        >

                            <!-- ========================= -->
                            <!-- Persian Section -->
                            <!-- ========================= -->

                            <div
                                dir="rtl"
                                lang="fa"
                                style="
                                    direction: rtl;
                                    text-align: right;
                                    font-family: Tahoma, Arial, sans-serif;
                                "
                            >

                                <!-- Heading -->
                                <h1
                                    style="
                                        margin: 0 0 22px 0;
                                        padding: 0;
                                        font-size: 24px;
                                        line-height: 1.7;
                                        font-weight: 700;
                                        color: #0f172a;
                                    "
                                >
                                    تأیید آدرس ایمیل
                                </h1>

                                <!-- Greeting -->
                                <p
                                    style="
                                        margin: 0 0 14px 0;
                                        font-size: 15px;
                                        line-height: 2;
                                        color: #334155;
                                    "
                                >
                                    سلام {{ $user->name }}،
                                </p>

                                <!-- Description -->
                                <p
                                    style="
                                        margin: 0 0 28px 0;
                                        font-size: 14px;
                                        line-height: 2.1;
                                        color: #475569;
                                    "
                                >
                                    برای تکمیل ثبت‌نام و فعال‌سازی حساب کاربری
                                    خود در AvaPark، لطفاً آدرس ایمیل خود را
                                    با کلیک روی دکمه زیر تأیید کنید.
                                </p>

                                <!-- CTA -->
                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                    style="margin: 0 0 28px 0;"
                                >
                                    <tr>
                                        <td align="right">

                                            <a
                                                href="{{ $verificationUrl }}"
                                                class="button"
                                                style="
                                                    display: inline-block;
                                                    padding: 13px 28px;
                                                    background-color: #2563eb;
                                                    border-radius: 7px;
                                                    color: #ffffff;
                                                    font-family: Tahoma, Arial, sans-serif;
                                                    font-size: 14px;
                                                    font-weight: 700;
                                                    line-height: 1.5;
                                                    text-decoration: none;
                                                "
                                            >
                                                تأیید آدرس ایمیل
                                            </a>

                                        </td>
                                    </tr>
                                </table>

                                <!-- Expiration Notice -->
                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                    style="
                                        margin: 0 0 22px 0;
                                        background-color: #f8fafc;
                                        border: 1px solid #e2e8f0;
                                        border-radius: 7px;
                                    "
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding: 13px 15px;
                                                font-size: 12px;
                                                line-height: 1.9;
                                                color: #64748b;
                                            "
                                        >
                                            این لینک تأیید به مدت
                                            <strong style="color: #334155;">
                                                ۶۰ دقیقه
                                            </strong>
                                            معتبر است.
                                        </td>
                                    </tr>
                                </table>

                                <!-- Security Message -->
                                <p
                                    style="
                                        margin: 0;
                                        font-size: 12px;
                                        line-height: 2;
                                        color: #64748b;
                                    "
                                >
                                    اگر شما این حساب کاربری را ایجاد نکرده‌اید،
                                    نیازی به انجام هیچ اقدامی نیست و می‌توانید
                                    این ایمیل را نادیده بگیرید.
                                </p>

                            </div>


                            <!-- ========================= -->
                            <!-- Divider -->
                            <!-- ========================= -->

                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                style="margin: 42px 0;"
                            >
                                <tr>
                                    <td
                                        style="
                                            height: 1px;
                                            background-color: #e2e8f0;
                                            line-height: 1px;
                                            font-size: 1px;
                                        "
                                    >
                                        &nbsp;
                                    </td>
                                </tr>
                            </table>


                            <!-- ========================= -->
                            <!-- English Section -->
                            <!-- ========================= -->

                            <div
                                dir="ltr"
                                lang="en"
                                style="
                                    direction: ltr;
                                    text-align: left;
                                    font-family: Arial, Helvetica, sans-serif;
                                "
                            >

                                <!-- Heading -->
                                <h2
                                    style="
                                        margin: 0 0 22px 0;
                                        padding: 0;
                                        font-size: 23px;
                                        line-height: 1.5;
                                        font-weight: 700;
                                        color: #0f172a;
                                    "
                                >
                                    Verify Your Email Address
                                </h2>

                                <!-- Greeting -->
                                <p
                                    style="
                                        margin: 0 0 14px 0;
                                        font-size: 15px;
                                        line-height: 1.8;
                                        color: #334155;
                                    "
                                >
                                    Hello {{ $user->name }},
                                </p>

                                <!-- Description -->
                                <p
                                    style="
                                        margin: 0 0 28px 0;
                                        font-size: 14px;
                                        line-height: 1.9;
                                        color: #475569;
                                    "
                                >
                                    To complete your registration and activate
                                    your AvaPark account, please verify your
                                    email address by clicking the button below.
                                </p>

                                <!-- CTA -->
                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                    style="margin: 0 0 28px 0;"
                                >
                                    <tr>
                                        <td align="left">

                                            <a
                                                href="{{ $verificationUrl }}"
                                                class="button"
                                                style="
                                                    display: inline-block;
                                                    padding: 13px 28px;
                                                    background-color: #2563eb;
                                                    border-radius: 7px;
                                                    color: #ffffff;
                                                    font-family: Arial, Helvetica, sans-serif;
                                                    font-size: 14px;
                                                    font-weight: 700;
                                                    line-height: 1.5;
                                                    text-decoration: none;
                                                "
                                            >
                                                Verify Email Address
                                            </a>

                                        </td>
                                    </tr>
                                </table>

                                <!-- Expiration Notice -->
                                <table
                                    width="100%"
                                    cellpadding="0"
                                    cellspacing="0"
                                    border="0"
                                    style="
                                        margin: 0 0 22px 0;
                                        background-color: #f8fafc;
                                        border: 1px solid #e2e8f0;
                                        border-radius: 7px;
                                    "
                                >
                                    <tr>
                                        <td
                                            style="
                                                padding: 13px 15px;
                                                font-size: 12px;
                                                line-height: 1.8;
                                                color: #64748b;
                                            "
                                        >
                                            This verification link is valid for
                                            <strong style="color: #334155;">
                                                60 minutes
                                            </strong>.
                                        </td>
                                    </tr>
                                </table>

                                <!-- Security Message -->
                                <p
                                    style="
                                        margin: 0;
                                        font-size: 12px;
                                        line-height: 1.9;
                                        color: #64748b;
                                    "
                                >
                                    If you did not create this account, no
                                    further action is required. You can safely
                                    ignore this email.
                                </p>

                            </div>


                            <!-- ========================= -->
                            <!-- Fallback Link -->
                            <!-- ========================= -->

                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                style="
                                    margin-top: 42px;
                                    border-top: 1px solid #e2e8f0;
                                "
                            >
                                <tr>
                                    <td style="padding-top: 24px;">

                                        <p
                                            style="
                                                margin: 0 0 10px 0;
                                                font-family: Tahoma, Arial, sans-serif;
                                                font-size: 11px;
                                                line-height: 1.8;
                                                color: #94a3b8;
                                                text-align: right;
                                                direction: rtl;
                                            "
                                        >
                                            اگر دکمه بالا برای شما کار نمی‌کند،
                                            لینک زیر را مستقیماً در مرورگر خود
                                            باز کنید:
                                        </p>

                                        <p
                                            style="
                                                margin: 0;
                                                font-family: Arial, Helvetica, sans-serif;
                                                font-size: 10px;
                                                line-height: 1.8;
                                                word-break: break-all;
                                                text-align: left;
                                                direction: ltr;
                                            "
                                        >
                                            <a
                                                href="{{ $verificationUrl }}"
                                                style="
                                                    color: #2563eb;
                                                    text-decoration: none;
                                                "
                                            >
                                                {{ $verificationUrl }}
                                            </a>
                                        </p>

                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>


                    <!-- ========================= -->
                    <!-- Footer -->
                    <!-- ========================= -->

                    <tr>
                        <td
                            class="email-footer"
                            align="center"
                            style="
                                padding: 28px 35px;
                                background-color: #f8fafc;
                                border-top: 1px solid #e2e8f0;
                            "
                        >

                            <p
                                style="
                                    margin: 0 0 8px 0;
                                    font-family: Tahoma, Arial, sans-serif;
                                    font-size: 11px;
                                    line-height: 1.8;
                                    color: #64748b;
                                    direction: rtl;
                                "
                            >
                                این ایمیل به صورت خودکار ارسال شده است.
                                لطفاً به آن پاسخ ندهید.
                            </p>

                            <p
                                style="
                                    margin: 0 0 8px 0;
                                    font-family: Arial, Helvetica, sans-serif;
                                    font-size: 11px;
                                    line-height: 1.8;
                                    color: #64748b;
                                "
                            >
                                This is an automated email.
                                Please do not reply.
                            </p>

                            <p
                                style="
                                    margin: 14px 0 0 0;
                                    font-family: Arial, Helvetica, sans-serif;
                                    font-size: 11px;
                                    line-height: 1.8;
                                    color: #94a3b8;
                                "
                            >
                                © {{ date('Y') }} AvaPark. All rights reserved.
                            </p>

                            <p style="margin: 8px 0 0 0;">
                                <a
                                    href="{{ config('app.url') }}"
                                    style="
                                        font-family: Arial, Helvetica, sans-serif;
                                        font-size: 11px;
                                        color: #2563eb;
                                        text-decoration: none;
                                    "
                                >
                                    {{ config('app.url') }}
                                </a>
                            </p>

                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>

</html>
