<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 0; }
        .wrapper { max-width: 600px; margin: 40px auto; background: #fff; border-radius: 8px; overflow: hidden; }
        .header { background: #0a0a0a; padding: 32px; text-align: center; }
        .header-brand { font-size: 14px; letter-spacing: 4px; text-transform: uppercase; color: #C8A96A; }
        .header-title { font-size: 20px; color: #f0e6d0; font-weight: 400; margin-top: 8px; }
        .body { padding: 32px; }
        .alert-box {
            background: #f9f6f0;
            border-left: 4px solid #C8A96A;
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 24px;
        }
        .alert-title { font-size: 16px; font-weight: 700; color: #0a0a0a; margin-bottom: 4px; }
        .alert-sub   { font-size: 13px; color: #666; }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }
        .info-item { background: #f9f9f9; border-radius: 6px; padding: 14px 16px; }
        .info-label { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: #8a7248; margin-bottom: 4px; }
        .info-val   { font-size: 14px; color: #0a0a0a; font-weight: 600; }
        .section-title { font-size: 11px; letter-spacing: 2px; text-transform: uppercase; color: #8a7248; margin-bottom: 12px; border-bottom: 1px solid #eee; padding-bottom: 8px; }
        .item { display: flex; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 13px; }
        .item:last-child { border-bottom: none; }
        .item-name { color: #333; }
        .item-total { color: #C8A96A; font-weight: 600; }
        .total-row { display: flex; justify-content: space-between; font-size: 13px; padding: 6px 0; color: #666; }
        .total-row.grand { border-top: 2px solid #eee; margin-top: 8px; padding-top: 12px; font-size: 16px; color: #0a0a0a; font-weight: 700; }
        .cta { text-align: center; margin: 28px 0; }
        .cta a { display: inline-block; padding: 13px 32px; background: #C8A96A; color: #0a0a0a; text-decoration: none; border-radius: 7px; font-size: 12px; font-weight: 700; letter-spacing: 2px; text-transform: uppercase; }
        .footer { background: #0a0a0a; padding: 20px 32px; text-align: center; }
        .footer p { font-size: 11px; color: #5a5040; margin: 4px 0; }
    </style>
</head>
<body>
<div class="wrapper">

    {{-- Header --}}
    <div class="header">
        <div class="header-brand">{{ config('app.name') }}</div>
        <div class="header-title">🛍️ {{ __('New Order Received') }}</div>
    </div>

    {{-- Body --}}
    <div class="body">

        {{-- Alert --}}
        <div class="alert-box">
            <div class="alert-title">{{ __('New order has been placed!') }}</div>
            <div class="alert-sub">{{ $order->created_at->format('d M Y, h:i A') }}</div>
        </div>

        {{-- Info Grid --}}
        <div class="info-grid">
            <div class="info-item">
                <div class="info-label">{{ __('Order Number') }}</div>
                <div class="info-val">{{ $order->order_number }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('Customer') }}</div>
                <div class="info-val">{{ $order->user?->name }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('Payment') }}</div>
                <div class="info-val">{{ ucfirst($order->payment_method) }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">{{ __('Total') }}</div>
                <div class="info-val" style="color:#C8A96A;">${{ number_format($order->total, 2) }}</div>
            </div>
        </div>

        {{-- Items --}}
        <div class="section-title">{{ __('Items') }}</div>
        @foreach($order->items as $item)
            <div class="item">
                <div class="item-name">
                    {{ $item->product_name }}
                    <span style="color:#999;font-size:12px;"> × {{ $item->quantity }}</span>
                </div>
                <div class="item-total">${{ number_format($item->total, 2) }}</div>
            </div>
        @endforeach

        {{-- Totals --}}
        <div style="margin-top:16px;">
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
                <span style="color:#C8A96A;">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>

        {{-- CTA --}}
        <div class="cta">
            <a href="{{ route('admin.order.show', $order->id) }}">
                {{ __('View Order in Dashboard') }}
            </a>
        </div>

    </div>

    {{-- Footer --}}
    <div class="footer">
        <p>{{ config('app.name') }} — {{ __('Admin Notification') }}</p>
    </div>

</div>
</body>
</html>