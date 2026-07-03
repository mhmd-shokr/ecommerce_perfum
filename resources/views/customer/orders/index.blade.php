@extends('layouts.customer.app')
@section('title', __('My Orders'))

@push('styles')
<style>
    .orders-wrap {
        max-width: 900px;
        margin: 60px auto 80px;
        padding: 0 24px;
    }
    .orders-hero {
        text-align: center;
        margin-bottom: 40px;
    }
    .orders-eyebrow {
        font-size: 10px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        margin-bottom: 10px;
    }
    .orders-title {
        font-family: 'Georgia', serif;
        font-size: 28px;
        font-weight: 400;
        color: var(--text-primary);
    }
    .orders-rule {
        width: 36px;
        height: 1px;
        background: var(--gold);
        opacity: 0.5;
        margin: 10px auto 0;
    }

    /* Stats */
    .orders-stats {
        display: flex;
        gap: 16px;
        margin-bottom: 32px;
    }
    .stat-card {
        flex: 1;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 10px;
        padding: 16px 20px;
        text-align: center;
    }
    .stat-val {
        font-size: 28px;
        color: var(--gold);
        font-family: 'Georgia', serif;
    }
    .stat-label {
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-top: 4px;
    }

    /* Table */
    .orders-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }
    .orders-table-header {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr 80px;
        gap: 16px;
        padding: 14px 24px;
        border-bottom: 1px solid var(--border);
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
    }
    .order-row {
        display: grid;
        grid-template-columns: 1.5fr 1fr 1fr 1fr 80px;
        gap: 16px;
        align-items: center;
        padding: 16px 24px;
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }
    .order-row:last-child { border-bottom: none; }
    .order-row:hover { background: rgba(200,169,106,0.02); }

    .order-number {
        font-size: 13px;
        color: var(--text-primary);
        font-family: Arial, sans-serif;
    }
    .order-date {
        font-size: 12px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-top: 3px;
    }
    .order-total {
        font-size: 14px;
        color: var(--gold);
        font-family: Arial, sans-serif;
    }

    /* Badges */
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

    .pay-badge {
        display: inline-block;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-family: Arial, sans-serif;
        letter-spacing: 1px;
        text-transform: uppercase;
    }
    .pay-pending  { background: rgba(200,169,106,0.08); color: var(--text-muted); }
    .pay-paid     { background: rgba(122,184,122,0.1);  color: #7ab87a; }
    .pay-failed   { background: rgba(196,80,64,0.1);    color: #c45040; }
    .pay-refunded { background: rgba(150,100,200,0.1);  color: #9664c8; }

    .view-btn {
        padding: 7px 14px;
        background: transparent;
        border: 1px solid var(--border);
        border-radius: 6px;
        color: var(--gold-dim);
        font-size: 11px;
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: all 0.15s;
        white-space: nowrap;
    }
    .view-btn:hover {
        border-color: var(--gold-dim);
        color: var(--gold);
    }

    /* Empty */
    .empty-orders {
        text-align: center;
        padding: 60px 20px;
    }
    .empty-orders-icon { font-size: 48px; margin-bottom: 16px; opacity: 0.3; }
    .empty-orders-title {
        font-family: 'Georgia', serif;
        font-size: 20px;
        font-weight: 400;
        color: var(--text-primary);
        margin-bottom: 8px;
    }
    .empty-orders-sub {
        font-size: 13px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 24px;
    }
    .btn-gold {
        display: inline-block;
        padding: 12px 28px;
        background: var(--gold);
        border-radius: 7px;
        color: #0a0a0a;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-decoration: none;
    }

    @media (max-width: 700px) {
        .orders-table-header { display: none; }
        .order-row { grid-template-columns: 1fr; gap: 8px; }
        .orders-stats { flex-direction: column; }
    }
</style>
@endpush

@section('content')
<div class="orders-wrap">

    {{-- Hero --}}
    <div class="orders-hero">
        <div class="orders-eyebrow">{{ __('Account') }}</div>
        <h1 class="orders-title">{{ __('My Orders') }}</h1>
        <div class="orders-rule"></div>
    </div>

    {{-- Stats --}}
    <div class="orders-stats">
        <div class="stat-card">
            <div class="stat-val">{{ $ordersCount }}</div>
            <div class="stat-label">{{ __('Total Orders') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-val">
                {{ $orders->where('status', 'delivered')->count() }}
            </div>
            <div class="stat-label">{{ __('Delivered') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-val">
                {{ $orders->where('status', 'processing')->count() }}
            </div>
            <div class="stat-label">{{ __('Processing') }}</div>
        </div>
    </div>

    {{-- Orders --}}
    <div class="orders-card">
        @if($orders->isEmpty())
            <div class="empty-orders">
                <div class="empty-orders-icon">📦</div>
                <div class="empty-orders-title">{{ __('No orders yet') }}</div>
                <div class="empty-orders-sub">
                    {{ __('Discover our luxury fragrances and place your first order.') }}
                </div>
                <a href="{{ route('shop.products') }}" class="btn-gold">
                    {{ __('Browse Collection') }}
                </a>
            </div>
        @else
            <div class="orders-table-header">
                <span>{{ __('Order') }}</span>
                <span>{{ __('Total') }}</span>
                <span>{{ __('Status') }}</span>
                <span>{{ __('Payment') }}</span>
                <span></span>
            </div>

            @foreach($orders as $order)
                <div class="order-row">
                    <div>
                        <div class="order-number">{{ $order->order_number }}</div>
                        <div class="order-date">
                            {{ $order->created_at->format('d M Y') }}
                        </div>
                    </div>
                    <div class="order-total">
                        ${{ number_format($order->total, 2) }}
                    </div>
                    <div>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ __($order->status) }}
                        </span>
                    </div>
                    <div>
                        <span class="pay-badge pay-{{ $order->payment_status }}">
                            {{ __($order->payment_status) }}
                        </span>
                    </div>
                    <div>
                        <a href="{{ route('my.order.show', $order->id) }}" class="view-btn">
                            {{ __('View') }}
                        </a>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    {{-- Pagination --}}
    @if($orders->hasPages())
        <div style="margin-top: 24px;">
            {{ $orders->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
@endsection