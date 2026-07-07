<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .wrapper {
            max-width: 600px;
            margin: 40px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .header {
            background: #0a0a0a;
            padding: 40px 32px;
            text-align: center;
        }
        .header-brand {
            font-size: 14px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #C8A96A;
        }
        .header-title {
            font-size: 22px;
            color: #f0e6d0;
            font-weight: 400;
            margin-top: 10px;
        }
        .header-rule {
            width: 36px;
            height: 1px;
            background: #C8A96A;
            margin: 12px auto 0;
            opacity: 0.5;
        }
        .body { padding: 40px 32px; text-align: center; }
        .greeting {
            font-size: 15px;
            color: #333;
            margin-bottom: 8px;
        }
        .sub {
            font-size: 13px;
            color: #666;
            line-height: 1.7;
            margin-bottom: 32px;
        }

        /* OTP Box */
        .otp-box {
            background: #f9f6f0;
            border: 2px dashed #C8A96A;
            border-radius: 12px;
            padding: 28px;
            margin: 0 auto 28px;
            max-width: 280px;
        }
        .otp-label {
            font-size: 10px;
            letter-spacing: 3px;
            text-transform: uppercase;
            color: #8a7248;
            margin-bottom: 12px;
        }
        .otp-code {
            font-size: 42px;
            font-weight: 700;
            color: #0a0a0a;
            letter-spacing: 10px;
            font-family: monospace;
        }
        .otp-expires {
            font-size: 11px;
            color: #999;
            margin-top: 10px;
        }

        .warning {
            font-size: 12px;
            color: #999;
            line-height: 1.6;
            margin-top: 20px;
        }
        .footer {
            background: #0a0a0a;
            padding: 24px 32px;
            text-align: center;
        }
        .footer p {
            font-size: 11px;
            color: #5a5040;
            margin: 4px 0;
        }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="header-brand">{{ config('app.name') }}</div>
        <div class="header-title">{{ __('Email Verification') }}</div>
        <div class="header-rule"></div>
    </div>

    {{-- Body --}}
    <div class="body">

        <p class="greeting">{{ __('Hello') }}, {{ $user->name }} 👋</p>
        <p class="sub">
            {{ __('Use the code below to verify your email address.') }}<br>
            {{ __('The code expires in 10 minutes.') }}
        </p>

        {{-- OTP --}}
        <div class="otp-box">
            <div class="otp-label">{{ __('Verification Code') }}</div>
            <div class="otp-code">{{ $otp }}</div>
            <div class="otp-expires">⏱ {{ __('Expires in 10 minutes') }}</div>
        </div>

        <p class="warning">
            {{ __('If you did not create an account, please ignore this email.') }}<br>
            {{ __('Do not share this code with anyone.') }}
        </p>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
    </div>

</div>
</body>
</html>