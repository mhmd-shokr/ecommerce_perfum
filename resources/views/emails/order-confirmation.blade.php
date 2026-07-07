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

        /* Header */
        .header {
            background: #0a0a0a;
            padding: 32px;
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
            margin-top: 8px;
        }
        .header-rule {
            width: 36px;
            height: 1px;
            background: #C8A96A;
            margin: 12px auto 0;
            opacity: 0.5;
        }

        /* Body */
        .body { padding: 32px; }

        .greeting {
            font-size: 15px;
            color: #333;
            margin-bottom: 8px;
        }
        .sub {
            font-size: 13px;
            color: #666;
            margin-bottom: 28px;
            line-height: 1.6;
        }

        /* Order Number */
        .order-number-box {
            background: #f9f6f0;
            border: 1px solid #e8dcc8;
            border-radius: 6px;
            padding: 14px 20px;
            text-align: center;
            margin-bottom: 28px;
        }
        .order-number-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8a7248;
        }
        .order-number-val {
            font-size: 18px;
            color: #0a0a0a;
            font-weight: 700;
            letter-spacing: 1px;
            margin-top: 4px;
        }

        /* Items */
        .section-title {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #8a7248;
            margin-bottom: 14px;
            padding-bottom: 8px;
            border-bottom: 1px solid #eee;
        }
        .item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
            font-size: 13px;
        }
        .item:last-child { border-bottom: none; }
        .item-name { color: #333; }
        .item-meta { color: #999; font-size: 12px; margin-top: 2px; }
        .item-total { color: #C8A96A; font-weight: 600; }

        /* Totals */
        .totals { margin-top: 20px; }
        .total-row {
            display: flex;
            justify-content: space-between;
            font-size: 13px;
            padding: 6px 0;
            color: #666;
        }
        .total-row.grand {
            border-top: 2px solid #eee;
            margin-top: 8px;
            padding-top: 12px;
            font-size: 16px;
            color: #0a0a0a;
            font-weight: 700;
        }
        .total-row.grand .val { color: #C8A96A; }

        /* Address */
        .address-box {
            background: #f9f9f9;
            border-radius: 6px;
            padding: 16px 20px;
            margin-top: 24px;
            font-size: 13px;
            color: #555;
            line-height: 1.8;
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
            letter-spacing: 0.5px;
        }
        .footer a { color: #C8A96A; text-decoration: none; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="header-brand">{{ config('app.name') }}</div>
        <div class="header-title">{{ __('Order Confirmed') }} ✓</div>
        <div class="header-rule"></div>
    </div>

    {{-- Body --}}
    <div class="body">

        <p class="greeting">{{ __('Hello') }}, {{ $order->user->name }} 👋</p>
        <p class="sub">
            {{ __('Thank you for your order! We have received it and will start processing it shortly.') }}
        </p>

        {{-- Order Number --}}
        <div class="order-number-box">
            <div class="order-number-label">{{ __('Order Number') }}</div>
            <div class="order-number-val">{{ $order->order_number }}</div>
        </div>

        {{-- Items --}}
        <div class="section-title">{{ __('Items Ordered') }}</div>

        @foreach($order->items as $item)
            <div class="item">
                <div>
                    <div class="item-name">{{ $item->product_name }}</div>
                    <div class="item-meta">
                        {{ __('Qty') }}: {{ $item->quantity }} ×
                        ${{ number_format($item->unit_price, 2) }}
                    </div>
                </div>
                <div class="item-total">
                    ${{ number_format($item->total, 2) }}
                </div>
            </div>
        @endforeach

        {{-- Totals --}}
        <div class="totals">
            <div class="total-row">
                <span>{{ __('Subtotal') }}</span>
                <span>${{ number_format($order->sub_total, 2) }}</span>
            </div>
            <div class="total-row">
                <span>{{ __('Shipping') }}</span>
                <span>${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="total-row">
                    <span>{{ __('Discount') }}</span>
                    <span style="color:#7ab87a;">-${{ number_format($order->discount, 2) }}</span>
                </div>
            @endif
            <div class="total-row grand">
                <span>{{ __('Total') }}</span>
                <span class="val">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        {{-- Address --}}
        <div class="section-title" style="margin-top:28px;">
            {{ __('Delivery Address') }}
        </div>
        <div class="address-box">
            <strong>{{ $order->address->full_name }}</strong><br>
            {{ $order->address->phone }}<br>
            {{ $order->address->street }},
            @if($order->address->building)
                {{ __('Building') }} {{ $order->address->building }},
            @endif
            @if($order->address->floor)
                {{ __('Floor') }} {{ $order->address->floor }},
            @endif
            <br>
            {{ $order->address->city }}, {{ $order->address->governorate }}
        </div>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</p>
        <p>{{ __('Questions?') }} <a href="mailto:support@example.com">support@example.com</a></p>
    </div>

</div>
</body>
</html>