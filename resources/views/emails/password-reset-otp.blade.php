<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() === 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Password Reset') }}</title>
</head>
<body style="margin:0;padding:0;background-color:#0a0a0a;font-family:Arial,sans-serif;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#0a0a0a;padding:40px 0;">
        <tr>
            <td align="center">
                <table role="presentation" width="480" cellpadding="0" cellspacing="0" style="max-width:480px;width:100%;background-color:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="padding:36px 40px 0;text-align:center;">
                            <div style="font-size:10px;letter-spacing:4px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:10px;">
                                {{ config('app.name') }}
                            </div>
                            <div style="width:36px;height:1px;background-color:#C8A96A;opacity:0.5;margin:0 auto 24px;"></div>
                        </td>
                    </tr>

                    {{-- Title --}}
                    <tr>
                        <td style="padding:0 40px;text-align:center;">
                            <h1 style="font-family:Georgia,serif;font-weight:400;font-size:22px;color:#f0e6d0;margin:0 0 12px;">
                                {{ __('Reset Your Password') }}
                            </h1>
                            <p style="font-size:13px;line-height:1.7;color:#9a8870;font-family:Arial,sans-serif;margin:0 0 28px;">
                                {{ __('Use the verification code below to reset your password. This code will expire shortly, so please use it soon.') }}
                            </p>
                        </td>
                    </tr>

                    {{-- OTP Code --}}
                    <tr>
                        <td style="padding:0 40px;text-align:center;">
                            <div style="background-color:rgba(200,169,106,0.06);border:1px solid rgba(200,169,106,0.25);border-radius:10px;padding:22px 20px;margin-bottom:28px;">
                                <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:10px;">
                                    {{ __('Verification Code') }}
                                </div>
                                <div style="font-size:34px;font-weight:700;letter-spacing:10px;color:#C8A96A;font-family:Arial,sans-serif;">
                                    {{ $otp }}
                                </div>
                            </div>
                        </td>
                    </tr>

                    {{-- Expiry note --}}
                    <tr>
                        <td style="padding:0 40px;text-align:center;">
                            <p style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;margin:0 0 28px;">
                                {{ __('This code expires in :minutes minutes.', ['minutes' => $expiresInMinutes ?? 10]) }}
                            </p>
                        </td>
                    </tr>

                    {{-- Divider --}}
                    <tr>
                        <td style="padding:0 40px;">
                            <div style="border-top:1px solid rgba(200,169,106,0.15);margin-bottom:24px;"></div>
                        </td>
                    </tr>

                    {{-- Security note --}}
                    <tr>
                        <td style="padding:0 40px 36px;text-align:center;">
                            <p style="font-size:12px;line-height:1.7;color:#5a5040;font-family:Arial,sans-serif;margin:0;">
                                {{ __("If you didn't request a password reset, you can safely ignore this email. Your password will remain unchanged.") }}
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="padding:20px 40px;border-top:1px solid rgba(200,169,106,0.1);text-align:center;">
                            <p style="font-size:11px;color:#5a5040;font-family:Arial,sans-serif;margin:0;">
                                &copy; {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>