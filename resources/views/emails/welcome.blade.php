<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #0a0a0a; padding: 40px 32px; text-align: center; }
        .header-brand { font-size: 14px; letter-spacing: 4px; text-transform: uppercase; color: #C8A96A; }
        .header-icon  { font-size: 48px; margin: 16px 0 8px; }
        .header-title { font-size: 24px; color: #f0e6d0; font-weight: 400; }
        .header-rule  { width: 36px; height: 1px; background: #C8A96A; margin: 14px auto 0; opacity: 0.5; }
        .body    { padding: 36px 32px; }
        .greeting { font-size: 16px; color: #222; margin-bottom: 12px; font-weight: 600; }
        .text    { font-size: 14px; color: #555; line-height: 1.8; margin-bottom: 20px; }
        .features { background: #f9f6f0; border-radius: 8px; padding: 20px 24px; margin: 24px 0; }
        .feature  { display: flex; align-items: flex-start; gap: 12px; padding: 10px 0; border-bottom: 1px solid #ede8de; }
        .feature:last-child { border-bottom: none; }
        .feature-icon  { font-size: 20px; flex-shrink: 0; }
        .feature-title { font-weight: 600; color: #333; margin-bottom: 2px; font-size: 13px; }
        .feature-text  { font-size: 13px; color: #555; line-height: 1.5; }
        .cta-wrap { text-align: center; margin: 28px 0; }
        .cta-btn  { display: inline-block; padding: 14px 36px; background: #C8A96A; color: #0a0a0a; text-decoration: none; border-radius: 7px; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .footer   { background: #0a0a0a; padding: 24px 32px; text-align: center; }
        .footer p { font-size: 11px; color: #5a5040; margin: 4px 0; }
        .footer a { color: #C8A96A; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="header-brand">{{ config('app.name') }}</div>
        <div class="header-icon">🌟</div>
        <div class="header-title">{{ __('Welcome Aboard!') }}</div>
        <div class="header-rule"></div>
    </div>

    {{-- Body --}}
    <div class="body">
        <p class="greeting">{{ __('Hello') }}, {{ $user->name }}! 👋</p>
        <p class="text">
            {{ __('Your email has been verified successfully. Welcome to') }}
            <strong>{{ config('app.name') }}</strong>.
        </p>

        <div class="features">
            <div class="feature">
                <div class="feature-icon">🛍️</div>
                <div>
                    <div class="feature-title">{{ __('Shop Our Collection') }}</div>
                    <div class="feature-text">{{ __('Explore hundreds of luxury fragrances.') }}</div>
                </div>
            </div>
            <div class="feature">
                <div class="feature-icon">❤️</div>
                <div>
                    <div class="feature-title">{{ __('Save Your Favourites') }}</div>
                    <div class="feature-text">{{ __('Add products to your wishlist.') }}</div>
                </div>
            </div>
            <div class="feature">
                <div class="feature-icon">📦</div>
                <div>
                    <div class="feature-title">{{ __('Track Your Orders') }}</div>
                    <div class="feature-text">{{ __('Follow your orders from placement to delivery.') }}</div>
                </div>
            </div>
        </div>

        <div class="cta-wrap">
            <a href="{{ url('/shop') }}" class="cta-btn">{{ __('Start Shopping') }}</a>
        </div>
    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
        <p><a href="{{ url('/') }}">{{ __('Visit our store') }}</a></p>
    </div>

</div>
</body>
</html>