<!DOCTYPE html>
<html lang="fa" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>تأیید آدرس ایمیل | AvaPark</title>
</head>

<body style="
    margin: 0;
    padding: 0;
    background-color: #f4f6f8;
    font-family: Tahoma, Arial, sans-serif;
    color: #1e293b;
">

    <table
        width="100%"
        cellpadding="0"
        cellspacing="0"
        border="0"
        style="
            width: 100%;
            background-color: #f4f6f8;
            padding: 40px 15px;
        "
    >
        <tr>
            <td align="center">

                <!-- Main Container -->
                <table
                    width="600"
                    cellpadding="0"
                    cellspacing="0"
                    border="0"
                    style="
                        width: 100%;
                        max-width: 600px;
                        background-color: #ffffff;
                        border: 1px solid #e2e8f0;
                        border-radius: 8px;
                    "
                >

                    <!-- Header -->
                    <tr>
                        <td
                            align="center"
                            style="
                                padding: 32px 30px;
                                border-bottom: 1px solid #e2e8f0;
                            "
                        >
                            <a
                                href="{{ config('app.url') }}"
                                style="
                                    text-decoration: none;
                                    color: #0f172a;
                                    font-size: 25px;
                                    font-weight: bold;
                                "
                            >
                                AvaPark
                            </a>
                        </td>
                    </tr>

                    <!-- Content -->
                    <tr>
                        <td
                            style="
                                padding: 42px 45px;
                                text-align: right;
                                direction: rtl;
                            "
                        >

                            <h1 style="
                                margin: 0 0 24px 0;
                                font-size: 24px;
                                line-height: 1.6;
                                font-weight: 700;
                                color: #0f172a;
                            ">
                                تأیید آدرس ایمیل
                            </h1>

                            <p style="
                                margin: 0 0 16px 0;
                                font-size: 15px;
                                line-height: 2;
                                color: #475569;
                            ">
                                سلام {{ $user->name }}،
                            </p>

                            <p style="
                                margin: 0 0 28px 0;
                                font-size: 15px;
                                line-height: 2;
                                color: #475569;
                            ">
                                برای تکمیل ثبت‌نام و فعال‌سازی حساب کاربری
                                خود در AvaPark، لطفاً آدرس ایمیل خود را
                                تأیید کنید.
                            </p>

                            <!-- Button -->
                            <table
                                width="100%"
                                cellpadding="0"
                                cellspacing="0"
                                border="0"
                                style="margin: 0 0 30px 0;"
                            >
                                <tr>
                                    <td align="center">

                                        <a
                                            href="{{ $verificationUrl }}"
                                            style="
                                                display: inline-block;
                                                padding: 13px 30px;
                                                background-color: #2563eb;
                                                border-radius: 6px;
                                                color: #ffffff;
                                                font-size: 15px;
                                                font-weight: bold;
                                                text-decoration: none;
                                            "
                                        >
                                            تأیید آدرس ایمیل
                                        </a>

                                    </td>
                                </tr>
                            </table>

                            <!-- Expiration -->
                            <p style="
                                margin: 0 0 24px 0;
                                padding: 14px 16px;
                                background-color: #f8fafc;
                                border-right: 3px solid #cbd5e1;
                                font-size: 13px;
                                line-height: 1.9;
                                color: #64748b;
                            ">
                                لینک تأیید آدرس ایمیل به مدت ۶۰ دقیقه
                                معتبر است.
                            </p>

                            <p style="
                                margin: 0 0 28px 0;
                                font-size: 13px;
                                line-height: 1.9;
                                color: #64748b;
                            ">
                                در صورتی که این حساب کاربری توسط شما ایجاد
                                نشده است، این ایمیل را نادیده بگیرید.
                            </p>

                            <!-- Divider -->
                            <div style="
                                height: 1px;
                                background-color: #e2e8f0;
                                margin: 28px 0;
                            "></div>

                            <!-- Fallback URL -->
                            <p style="
                                margin: 0 0 8px 0;
                                font-size: 12px;
                                line-height: 1.8;
                                color: #94a3b8;
                            ">
                                در صورت عدم عملکرد دکمه، می‌توانید لینک زیر
                                را مستقیماً در مرورگر خود باز کنید:
                            </p>

                            <a
                                href="{{ $verificationUrl }}"
                                style="
                                    display: block;
                                    font-size: 11px;
                                    line-height: 1.8;
                                    color: #2563eb;
                                    text-decoration: none;
                                    word-break: break-all;
                                    direction: ltr;
                                    text-align: left;
                                "
                            >
                                {{ $verificationUrl }}
                            </a>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td
                            align="center"
                            style="
                                padding: 25px 30px;
                                background-color: #f8fafc;
                                border-top: 1px solid #e2e8f0;
                            "
                        >

                            <p style="
                                margin: 0 0 8px 0;
                                font-size: 12px;
                                color: #64748b;
                                line-height: 1.8;
                            ">
                                این ایمیل به صورت خودکار ارسال شده است.
                                لطفاً به آن پاسخ ندهید.
                            </p>

                            <p style="
                                margin: 0;
                                font-size: 12px;
                                color: #94a3b8;
                                line-height: 1.8;
                            ">
                                © {{ date('Y') }} AvaPark. تمامی حقوق محفوظ است.
                            </p>

                            <p style="
                                margin: 8px 0 0 0;
                            ">
                                <a
                                    href="{{ config('app.url') }}"
                                    style="
                                        font-size: 12px;
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

