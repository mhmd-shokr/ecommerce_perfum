{{-- resources/views/customer/order-confirmed.blade.php --}}
@extends('layouts.customer.app')

@section('title', __('Order Confirmed'))

@push('styles')
<style>
    .confirmed-wrap {
        max-width: 720px;
        margin: 60px auto 80px;
        padding: 0 24px;
        text-align: center;
    }

    .confirmed-icon {
        width: 64px;
        height: 64px;
        background: rgba(200,169,106,0.1);
        border: 1px solid rgba(200,169,106,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
    }
    .confirmed-icon svg {
        width: 28px;
        height: 28px;
        stroke: var(--gold);
        fill: none;
    }

    .confirmed-title {
        font-family: 'Georgia', serif;
        font-size: 28px;
        font-weight: 400;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .confirmed-sub {
        font-size: 13px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 32px;
    }
    .confirmed-number {
        display: inline-block;
        padding: 8px 20px;
        background: rgba(200,169,106,0.08);
        border: 1px solid rgba(200,169,106,0.25);
        border-radius: 6px;
        font-size: 13px;
        color: var(--gold);
        font-family: Arial, sans-serif;
        letter-spacing: 1px;
        margin-bottom: 32px;
    }

    /* Order Details Card */
    .order-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
        text-align: left;
    }
    .order-card-header {
        padding: 14px 24px;
        border-bottom: 1px solid var(--border);
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
    }
    .order-card-body { padding: 20px 24px; }

    /* Items */
    .confirmed-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .confirmed-item:last-child { border-bottom: none; }
    .confirmed-item-img {
        width: 52px;
        height: 52px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid var(--border);
        flex-shrink: 0;
    }
    .confirmed-item-name { font-size: 13px; color: var(--text-primary); font-family: Arial, sans-serif; }
    .confirmed-item-meta { font-size: 12px; color: var(--text-muted); font-family: Arial, sans-serif; }
    .confirmed-item-total { margin-left: auto; font-size: 14px; color: var(--gold); font-family: Arial, sans-serif; }

    /* Summary rows */
    .summary-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-family: Arial, sans-serif;
        margin-bottom: 10px;
    }
    .summary-row .label { color: var(--text-secondary); }
    .summary-row .val   { color: var(--text-primary); }
    .summary-row.total  { border-top: 1px solid var(--border); padding-top: 12px; margin-top: 6px; }
    .summary-row.total .label { color: var(--text-primary); font-weight: 600; font-size: 14px; }
    .summary-row.total .val   { color: var(--gold); font-size: 18px; font-weight: 700; }

    /* Address */
    .address-text {
        font-size: 13px;
        color: var(--text-secondary);
        font-family: Arial, sans-serif;
        line-height: 1.8;
    }

    /* CTA */
    .confirmed-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        margin-top: 28px;
    }
    .btn-gold {
        padding: 12px 28px;
        background: var(--gold);
        border: none;
        border-radius: 7px;
        color: #0a0a0a;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-gold:hover { opacity: 0.88; }
    .btn-outline {
        padding: 12px 28px;
        background: transparent;
        border: 1px solid var(--border-strong);
        border-radius: 7px;
        color: var(--gold);
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-outline:hover { background: rgba(200,169,106,0.08); }
</style>
@endpush

@section('content')
<div class="confirmed-wrap">

    {{-- Icon --}}
    <div class="confirmed-icon">
        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <polyline points="20 6 9 17 4 12"/>
        </svg>
    </div>

    <h1 class="confirmed-title">{{ __('Order Confirmed!') }}</h1>
    <p class="confirmed-sub">{{ __('Thank you for your purchase. We will contact you shortly.') }}</p>
    <div class="confirmed-number">{{ $order->order_number }}</div>

    {{-- Order Items --}}
    <div class="order-card">
        <div class="order-card-header">{{ __('Items Ordered') }}</div>
        <div class="order-card-body">
            @foreach($order->items as $item)
                <div class="confirmed-item">
                    @if($item->product?->images)
                        <img src="{{ asset('storage/' . $item->product->images) }}"
                            alt="{{ $item->product_name }}"
                            class="confirmed-item-img">
                    @else
                        <div class="confirmed-item-img"
                            style="display:flex;align-items:center;justify-content:center;font-size:22px;background:rgba(200,169,106,0.06);">
                            🧴
                        </div>
                    @endif
                    <div>
                        <div class="confirmed-item-name">{{ $item->product_name }}</div>
                        <div class="confirmed-item-meta">
                            {{ __('Qty') }}: {{ $item->quantity }} ×
                            ${{ number_format($item->unit_price, 2) }}
                        </div>
                    </div>
                    <div class="confirmed-item-total">
                        ${{ number_format($item->total, 2) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Order Summary --}}
    <div class="order-card">
        <div class="order-card-header">{{ __('Payment Summary') }}</div>
        <div class="order-card-body">
            <div class="summary-row">
                <span class="label">{{ __('Subtotal') }}</span>
                <span class="val">${{ number_format($order->sub_total, 2) }}</span>
            </div>
            <div class="summary-row">
                <span class="label">{{ __('Shipping') }}</span>
                <span class="val">${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="summary-row">
                    <span class="label">{{ __('Discount') }}</span>
                    <span class="val" style="color:var(--success)">
                        -${{ number_format($order->discount, 2) }}
                    </span>
                </div>
            @endif
            <div class="summary-row total">
                <span class="label">{{ __('Total') }}</span>
                <span class="val">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Delivery Address --}}
    <div class="order-card">
        <div class="order-card-header">{{ __('Delivery Address') }}</div>
        <div class="order-card-body">
            <div class="address-text">
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
    </div>

    {{-- Actions --}}
    <div class="confirmed-actions">
        <a href="{{ route('shop.products') }}" class="btn-gold">
            {{ __('Continue Shopping') }}
        </a>
        <a href="#" class="btn-outline">
            {{ __('Track Order') }}
        </a>
    </div>

</div>
@endsection