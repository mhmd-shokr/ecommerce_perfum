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
            background: #fff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
        }

        /* Header */
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

        .header-rule {
            width: 36px;
            height: 1px;
            background: #C8A96A;
            margin: 14px auto 0;
            opacity: 0.5;
        }

        /* Image */
        .offer-image {
            width: 100%;
            max-height: 280px;
            object-fit: cover;
            display: block;
        }

        /* Body */
        .body {
            padding: 36px 32px;
        }

        .greeting {
            font-size: 15px;
            color: #333;
            margin-bottom: 16px;
        }

        .offer-title {
            font-size: 26px;
            color: #0a0a0a;
            font-weight: 700;
            margin-bottom: 16px;
            line-height: 1.3;
        }

        .offer-desc {
            font-size: 14px;
            color: #555;
            line-height: 1.8;
            margin-bottom: 28px;
        }

        /* CTA */
        .cta-wrap {
            text-align: center;
            margin: 28px 0;
        }

        .cta-btn {
            display: inline-block;
            padding: 14px 40px;
            background: #C8A96A;
            color: #0a0a0a;
            text-decoration: none;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
        }

        /* Footer */
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

        .footer a {
            color: #C8A96A;
            text-decoration: none;
        }

        .unsubscribe {
            font-size: 11px;
            color: #bbb;
            text-align: center;
            padding: 16px 32px;
        }

        .unsubscribe a {
            color: #999;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <div class="header-brand">{{ config('app.name') }}</div>
            <div class="header-rule"></div>
        </div>

        {{-- Offer Image --}}
        @if($offer->image)
            <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->title }}" class="offer-image">
        @endif

        {{-- Body --}}
        <div class="body">

            <p class="greeting">{{ __('Hello') }}, {{ $user->name }} 👋</p>

            <div class="offer-title">{{ $offer->title }}</div>

            <div class="offer-desc">{{ $offer->description }}</div>
            <div class="offer-desc">
                Coupon Code: {{ $offer->coupon?->code ?? 'N/A' }}
            </div>           
            <div class="offer-expires">
                Expires At:
                {{ $offer->expires_at?->format('d M Y') ?? 'No expiry date' }}
            </div>

            {{-- CTA Button --}}
            @if($offer->button_text && $offer->button_url)
                <div class="cta-wrap">
                    <a href="{{ $offer->button_url }}" class="cta-btn">
                        {{ $offer->button_text }}
                    </a>
                </div>
            @endif

        </div>

        {{-- Footer --}}
        <div class="footer">
            <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
            <p><a href="{{ url('/') }}">{{ __('Visit our store') }}</a></p>
        </div>

    </div>
</body>

</html>