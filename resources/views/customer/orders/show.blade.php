@extends('layouts.customer.app')
@section('title', __('Order Details'))

@push('styles')
<style>
    .order-wrap {
        max-width: 800px;
        margin: 60px auto 80px;
        padding: 0 24px;
    }
    .order-hero {
        text-align: center;
        margin-bottom: 32px;
    }
    .order-eyebrow {
        font-size: 10px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        margin-bottom: 10px;
    }
    .order-title {
        font-family: 'Georgia', serif;
        font-size: 26px;
        font-weight: 400;
        color: var(--text-primary);
    }
    .order-rule {
        width: 36px;
        height: 1px;
        background: var(--gold);
        opacity: 0.5;
        margin: 10px auto 0;
    }
    .o-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 20px;
    }
    .o-card-header {
        padding: 14px 24px;
        border-bottom: 1px solid var(--border);
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .o-card-body { padding: 20px 24px; }

    .status-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-family: Arial, sans-serif;
        letter-spacing: 1px;
        text-transform: uppercase;
        font-weight: 600;
    }
    .status-pending    { background: rgba(200,169,106,0.1); color: var(--gold-dim); }
    .status-processing { background: rgba(100,150,255,0.1); color: #6496ff; }
    .status-shipped    { background: rgba(100,200,255,0.1); color: #64c8ff; }
    .status-delivered  { background: rgba(122,184,122,0.1); color: #7ab87a; }
    .status-cancelled  { background: rgba(196,80,64,0.1);   color: #c45040; }

    .o-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 12px 0;
        border-bottom: 1px solid var(--border);
    }
    .o-item:last-child { border-bottom: none; }
    .o-item-img {
        width: 56px;
        height: 56px;
        border-radius: 8px;
        object-fit: cover;
        border: 1px solid var(--border);
        flex-shrink: 0;
        background: rgba(200,169,106,0.06);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
    }
    .o-item-name {
        font-size: 13px;
        color: var(--text-primary);
        font-family: Arial, sans-serif;
        margin-bottom: 3px;
    }
    .o-item-meta {
        font-size: 12px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
    }
    .o-item-total {
        margin-left: auto;
        font-size: 14px;
        color: var(--gold);
        font-family: Arial, sans-serif;
        font-weight: 600;
    }

    .o-row {
        display: flex;
        justify-content: space-between;
        font-size: 13px;
        font-family: Arial, sans-serif;
        margin-bottom: 10px;
    }
    .o-row .label { color: var(--text-secondary); }
    .o-row .val   { color: var(--text-primary); }
    .o-row.total {
        border-top: 1px solid var(--border);
        padding-top: 12px;
        margin-top: 6px;
        margin-bottom: 0;
    }
    .o-row.total .label {
        font-size: 14px;
        color: var(--text-primary);
        font-weight: 600;
    }
    .o-row.total .val {
        font-size: 18px;
        color: var(--gold);
        font-weight: 700;
    }

    .address-text {
        font-size: 13px;
        color: var(--text-secondary);
        font-family: Arial, sans-serif;
        line-height: 1.8;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 16px;
    }
    .info-item-label {
        font-size: 10px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 4px;
    }
    .info-item-val {
        font-size: 13px;
        color: var(--text-primary);
        font-family: Arial, sans-serif;
    }

    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        text-decoration: none;
        margin-bottom: 24px;
        transition: color 0.15s;
    }
    .back-link:hover { color: var(--gold); }
</style>
@endpush

@section('content')
<div class="order-wrap">

    <a href="{{ route('my.orders.index') }}" class="back-link">
        ← {{ __('Back to Orders') }}
    </a>

    {{-- Hero --}}
    <div class="order-hero">
        <div class="order-eyebrow">{{ __('Order Details') }}</div>
        <h1 class="order-title">{{ $order->order_number }}</h1>
        <div class="order-rule"></div>
    </div>

    {{-- Order Info --}}
    <div class="o-card">
        <div class="o-card-header">
            <span>{{ __('Order Information') }}</span>
            <span class="status-badge status-{{ $order->status }}">
                {{ __($order->status) }}
            </span>
        </div>
        <div class="o-card-body">
            <div class="info-grid">
                <div>
                    <div class="info-item-label">{{ __('Order Date') }}</div>
                    <div class="info-item-val">
                        {{ $order->created_at->format('d M Y, h:i A') }}
                    </div>
                </div>
                <div>
                    <div class="info-item-label">{{ __('Payment Method') }}</div>
                    <div class="info-item-val">
                        {{ ucfirst($order->payment_method) }}
                    </div>
                </div>
                <div>
                    <div class="info-item-label">{{ __('Payment Status') }}</div>
                    <div class="info-item-val">
                        {{ ucfirst($order->payment_status) }}
                    </div>
                </div>
                <div>
                    <div class="info-item-label">{{ __('Order Status') }}</div>
                    <div class="info-item-val">
                        {{ ucfirst($order->status) }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Items --}}
    <div class="o-card">
        <div class="o-card-header">{{ __('Items Ordered') }}</div>
        <div class="o-card-body">
            @foreach($order->items as $item)
                <div class="o-item">
                    @if($item->product?->images)
                        <img src="{{ asset('storage/' . $item->product->images) }}"
                             alt="{{ $item->product_name }}"
                             class="o-item-img"
                             style="display:block;">
                    @else
                        <div class="o-item-img">🧴</div>
                    @endif
                    <div>
                        <div class="o-item-name">{{ $item->product_name }}</div>
                        <div class="o-item-meta">
                            {{ __('Qty') }}: {{ $item->quantity }} ×
                            ${{ number_format($item->unit_price, 2) }}
                        </div>
                    </div>
                    <div class="o-item-total">
                        ${{ number_format($item->total, 2) }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Payment Summary --}}
    <div class="o-card">
        <div class="o-card-header">{{ __('Payment Summary') }}</div>
        <div class="o-card-body">
            <div class="o-row">
                <span class="label">{{ __('Subtotal') }}</span>
                <span class="val">${{ number_format($order->sub_total, 2) }}</span>
            </div>
            <div class="o-row">
                <span class="label">{{ __('Shipping') }}</span>
                <span class="val">${{ number_format($order->shipping_cost, 2) }}</span>
            </div>
            @if($order->discount > 0)
                <div class="o-row">
                    <span class="label">{{ __('Discount') }}</span>
                    <span class="val" style="color:#7ab87a;">
                        -${{ number_format($order->discount, 2) }}
                    </span>
                </div>
            @endif
            <div class="o-row total">
                <span class="label">{{ __('Total') }}</span>
                <span class="val">${{ number_format($order->total, 2) }}</span>
            </div>
        </div>
    </div>

    {{-- Delivery Address --}}
    <div class="o-card">
        <div class="o-card-header">{{ __('Delivery Address') }}</div>
        <div class="o-card-body">
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

</div>
@endsection