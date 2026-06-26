@extends('layouts.customer.app')

@section('title', __('My Cart'))

@push('styles')
<style>
    .cart-breadcrumb {
        max-width: 1200px;
        margin: 0 auto;
        padding: 14px 32px;
        font-size: 11px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        letter-spacing: 0.5px;
    }
    .cart-breadcrumb a { color: var(--text-muted); text-decoration: none; }
    .cart-breadcrumb a:hover { color: var(--gold); }
    .cart-breadcrumb span { color: var(--gold-dim); }

    .cart-hero {
        text-align: center;
        padding: 40px 32px 32px;
        border-bottom: 1px solid var(--border);
    }
    .cart-eyebrow {
        font-size: 10px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        margin-bottom: 10px;
    }
    .cart-title {
        font-family: 'Georgia', serif;
        font-size: 30px;
        font-weight: 400;
        color: var(--text-primary);
        margin-bottom: 6px;
    }
    .cart-rule {
        width: 36px; height: 1px;
        background: var(--gold);
        opacity: 0.5;
        margin: 0 auto;
    }

    .cart-layout {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 32px 80px;
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 32px;
        align-items: start;
    }

    /* ── FLASH ── */
    .cart-flash {
        max-width: 1200px;
        margin: 20px auto 0;
        padding: 0 32px;
    }
    .flash-inner {
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 8px;
        padding: 12px 18px;
        font-size: 13px;
        font-family: Arial, sans-serif;
    }
    .flash-inner.success {
        background: rgba(200,169,106,0.08);
        border: 1px solid rgba(200,169,106,0.3);
        color: var(--gold);
    }
    .flash-inner.error {
        background: rgba(224,92,92,0.08);
        border: 1px solid rgba(224,92,92,0.3);
        color: #e05c5c;
    }
    .flash-dot {
        width: 6px; height: 6px;
        border-radius: 50%;
        flex-shrink: 0;
    }
    .flash-inner.success .flash-dot { background: var(--gold); }
    .flash-inner.error   .flash-dot { background: #e05c5c; }

    /* ── ITEMS ── */
    .cart-items {
        display: flex;
        flex-direction: column;
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
    }

    .cart-items-header {
        display: grid;
        grid-template-columns: 1fr 110px 150px 90px;
        gap: 16px;
        padding: 14px 24px;
        border-bottom: 1px solid var(--border);
        font-size: 10px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
    }

    .cart-item {
        display: grid;
        grid-template-columns: 1fr 110px 150px 90px;
        gap: 16px;
        align-items: center;
        padding: 20px 24px;
        border-bottom: 1px solid var(--border);
        transition: background 0.15s;
    }
    .cart-item:last-child { border-bottom: none; }
    .cart-item:hover { background: rgba(200,169,106,0.02); }

    .item-product {
        display: flex;
        align-items: center;
        gap: 16px;
    }
    .item-img {
        width: 68px; height: 68px;
        border-radius: 8px;
        overflow: hidden;
        background: rgba(200,169,106,0.06);
        border: 1px solid var(--border);
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 28px;
    }
    .item-img img { width: 100%; height: 100%; object-fit: cover; }
    .item-name {
        font-size: 14px;
        color: var(--text-primary);
        font-family: Arial, sans-serif;
        line-height: 1.4;
        margin-bottom: 4px;
    }
    .item-desc {
        font-size: 11px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        line-height: 1.4;
    }

    .item-price {
        font-size: 15px;
        color: var(--gold);
        font-family: Arial, sans-serif;
        text-align: center;
    }

    /* ── QTY CONTROLS ── */
    .item-qty {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .qty-wrap {
        display: flex;
        align-items: center;
    }
    .qty-btn {
        width: 30px; height: 30px;
        background: var(--bg-card);
        border: 1px solid var(--border);
        color: var(--text-secondary);
        font-size: 16px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.15s;
        font-family: Arial, sans-serif;
        line-height: 1;
    }
    .qty-btn.minus { border-radius: 6px 0 0 6px; }
    .qty-btn.plus  { border-radius: 0 6px 6px 0; }
    .qty-btn:hover {
        background: rgba(200,169,106,0.12);
        border-color: var(--gold-dim);
        color: var(--gold);
    }
    .qty-num {
        width: 40px; height: 30px;
        background: rgba(200,169,106,0.04);
        border: 1px solid var(--border);
        border-left: none; border-right: none;
        color: var(--text-primary);
        font-size: 13px;
        font-family: Arial, sans-serif;
        text-align: center;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* ── SUBTOTAL + REMOVE ── */
    .item-subtotal {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
    }
    .subtotal-val {
        font-size: 15px;
        color: var(--text-primary);
        font-family: Arial, sans-serif;
        font-weight: 600;
    }
    .remove-btn {
        background: none;
        border: none;
        cursor: pointer;
        color: var(--text-muted);
        padding: 4px;
        border-radius: 4px;
        display: flex;
        align-items: center;
        transition: color 0.15s;
    }
    .remove-btn:hover { color: #e05c5c; }
    .remove-btn svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }

    /* ── CART FOOTER ── */
    .cart-footer-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 24px;
        background: rgba(200,169,106,0.03);
        border-top: 1px solid var(--border);
    }
    .clear-cart-btn {
        background: none;
        border: 1px solid var(--border);
        border-radius: 6px;
        color: var(--text-muted);
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        padding: 9px 18px;
        cursor: pointer;
        transition: all 0.15s;
    }
    .clear-cart-btn:hover { border-color: #e05c5c; color: #e05c5c; }
    .continue-link {
        font-size: 12px;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        transition: color 0.15s;
    }
    .continue-link:hover { color: var(--gold); }
    .continue-link svg { width: 13px; height: 13px; stroke: currentColor; fill: none; }

    /* ── ORDER SUMMARY ── */
    .order-summary {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        overflow: hidden;
        position: sticky;
        top: 90px;
    }
    .summary-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid var(--border);
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
    }
    .summary-body { padding: 20px 24px; }
    .summary-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 14px;
        font-size: 13px;
        font-family: Arial, sans-serif;
    }
    .summary-row .label { color: var(--text-secondary); }
    .summary-row .val   { color: var(--text-primary); }
    .summary-row.total-row {
        border-top: 1px solid var(--border);
        padding-top: 16px;
        margin-top: 6px;
        margin-bottom: 0;
    }
    .summary-row.total-row .label { font-size: 14px; color: var(--text-primary); font-weight: 600; }
    .summary-row.total-row .val   { font-size: 20px; color: var(--gold); font-weight: 700; }

    .checkout-btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: var(--gold);
        border: none;
        border-radius: 8px;
        color: #0a0a0a;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-align: center;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.15s;
        text-decoration: none;
        margin-top: 20px;
        box-sizing: border-box;
    }
    .checkout-btn:hover   { opacity: 0.88; }
    .checkout-btn:active  { transform: translateY(1px); }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 12px;
        font-size: 11px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
    }
    .secure-note svg { width: 12px; height: 12px; stroke: currentColor; fill: none; }

    /* ── EMPTY CART ── */
    .empty-cart {
        grid-column: 1 / -1;
        text-align: center;
        padding: 80px 20px;
    }
    .empty-cart-icon  { font-size: 52px; margin-bottom: 20px; opacity: 0.35; }
    .empty-cart-title {
        font-family: 'Georgia', serif;
        font-size: 22px;
        color: var(--text-primary);
        font-weight: 400;
        margin-bottom: 8px;
    }
    .empty-cart-sub {
        font-size: 13px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 28px;
    }
    .btn-shop {
        display: inline-block;
        padding: 13px 32px;
        background: var(--gold);
        color: #0a0a0a;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: opacity 0.2s;
    }
    .btn-shop:hover { opacity: 0.88; }

    /* ── RESPONSIVE ── */
    @media (max-width: 900px) {
        .cart-layout { grid-template-columns: 1fr; padding: 24px 16px 60px; }
        .order-summary { position: static; }
        .cart-items-header { display: none; }
        .cart-item { grid-template-columns: 1fr auto; grid-template-rows: auto auto; gap: 12px; }
        .item-price { display: none; }
        .item-qty   { justify-content: flex-start; }
        .item-subtotal { justify-content: flex-end; }
    }
    @media (max-width: 560px) {
        .cart-hero { padding: 28px 16px 24px; }
        .cart-breadcrumb { padding: 12px 16px; }
        .cart-flash { padding: 0 16px; }
        .cart-item { padding: 16px; }
    }
</style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="cart-breadcrumb">
        <a href="{{ route('home') }}">{{ __('Home') }}</a> /
        <a href="{{ route('shop.products') }}">{{ __('Shop') }}</a> /
        <span>{{ __('Cart') }}</span>
    </div>

    {{-- Hero --}}
    <div class="cart-hero">
        <div class="cart-eyebrow">{{ __('Your Selection') }}</div>
        <h1 class="cart-title">{{ __('Shopping Cart') }}</h1>
        <div class="cart-rule"></div>
    </div>

    {{-- Flash messages --}}
    {{-- @if(session('success'))
        <div class="cart-flash" id="cartFlash">
            <div class="flash-inner success">
                <span class="flash-dot"></span>
                {{ session('success') }}
            </div>
        </div>
    @endif --}}
    @if(session('error'))
        <div class="cart-flash" id="cartFlash">
            <div class="flash-inner error">
                <span class="flash-dot"></span>
                {{ session('error') }}
            </div>
        </div>
    @endif

    @php
        $itemCount = array_sum(array_column($cart, 'quantity'));
        $subtotal  = array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cart));
        $shipping  = $subtotal > 0 ? 10.00 : 0.00;
        $total     = $subtotal + $shipping;
    @endphp

    <div class="cart-layout">

        @if(count($cart) === 0)

            <div class="empty-cart">
                <div class="empty-cart-icon">🛒</div>
                <div class="empty-cart-title">{{ __('Your cart is empty') }}</div>
                <div class="empty-cart-sub">{{ __('Discover our luxury fragrances and add your favourites.') }}</div>
                <a href="{{ route('shop.products') }}" class="btn-shop">{{ __('Browse Collection') }}</a>
            </div>

        @else

            {{-- ══ ITEMS ══ --}}
            <div>
                <div class="cart-items">

                    <div class="cart-items-header">
                        <span>{{ __('Product') }}</span>
                        <span style="text-align:center;">{{ __('Price') }}</span>
                        <span style="text-align:center;">{{ __('Quantity') }}</span>
                        <span style="text-align:right;">{{ __('Subtotal') }}</span>
                    </div>

                    @foreach($cart as $productId => $item)
                        <div class="cart-item">

                            {{-- Product info --}}
                            <div class="item-product">
                                <div class="item-img">
                                    @if(!empty($item['images']))
                                        <img src="{{ asset('storage/' . $item['images']) }}"
                                             alt="{{ $item['name'] }}" loading="lazy">
                                    @else
                                        🧴
                                    @endif
                                </div>
                                <div>
                                    <div class="item-name">{{ $item['name'] }}</div>
                                    @if(!empty($item['short_description']))
                                        <div class="item-desc">
                                            {{ Str::limit($item['short_description'], 60) }}
                                        </div>
                                    @endif
                                </div>
                            </div>

                            {{-- Unit price --}}
                            <div class="item-price">
                                ${{ number_format($item['price'], 2) }}
                            </div>

                            {{-- Quantity: − num + via two separate forms --}}
                            <div class="item-qty">
                                <div class="qty-wrap">

                                    {{-- Decrease --}}
                                    <form method="POST"
                                          action="{{ route('cart.update', $productId) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity"
                                               value="{{ max(1, $item['quantity'] - 1) }}">
                                        <button type="submit" class="qty-btn minus"
                                                aria-label="{{ __('Decrease') }}"
                                                {{ $item['quantity'] <= 1 ? 'disabled' : '' }}>−</button>
                                    </form>

                                    <span class="qty-num">{{ $item['quantity'] }}</span>

                                    {{-- Increase --}}
                                    <form method="POST"
                                          action="{{ route('cart.update', $productId) }}">
                                        @csrf @method('PATCH')
                                        <input type="hidden" name="quantity"
                                               value="{{ $item['quantity'] + 1 }}">
                                        <button type="submit" class="qty-btn plus"
                                                aria-label="{{ __('Increase') }}">+</button>
                                    </form>

                                </div>
                            </div>

                            {{-- Subtotal + remove --}}
                            <div class="item-subtotal">
                                <span class="subtotal-val">
                                    ${{ number_format($item['price'] * $item['quantity'], 2) }}
                                </span>
                                <form method="POST"
                                      action="{{ route('cart.remove', $productId) }}">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="remove-btn"
                                            aria-label="{{ __('Remove item') }}"
                                            title="{{ __('Remove') }}">
                                        <svg viewBox="0 0 24 24" stroke-width="1.5"
                                             stroke-linecap="round" stroke-linejoin="round">
                                            <polyline points="3 6 5 6 21 6"/>
                                            <path d="M19 6l-1 14H6L5 6"/>
                                            <path d="M10 11v6M14 11v6"/>
                                            <path d="M9 6V4h6v2"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>

                        </div>
                    @endforeach

                    {{-- Footer row --}}
                    <div class="cart-footer-row">
                        <a href="{{ route('shop.products') }}" class="continue-link">
                            <svg viewBox="0 0 24 24" stroke-width="1.5"
                                 stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6"/>
                            </svg>
                            {{ __('Continue Shopping') }}
                        </a>
                        <form method="POST" action="{{ route('cart.clear') }}">
                            @csrf @method('DELETE')
                            <button type="submit" class="clear-cart-btn"
                                    onclick="return confirm('{{ addslashes(__('Clear entire cart?')) }}')">
                                {{ __('Clear Cart') }}
                            </button>
                        </form>
                    </div>

                </div>
            </div>

            {{-- ══ ORDER SUMMARY ══ --}}
            <div class="order-summary">
                <div class="summary-header">{{ __('Order Summary') }}</div>
                <div class="summary-body">

                    <div class="summary-row">
                        <span class="label">{{ __('Items') }} ({{ $itemCount }})</span>
                        <span class="val">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="label">{{ __('Shipping') }}</span>
                        <span class="val">
                            @if($shipping > 0)
                                ${{ number_format($shipping, 2) }}
                            @else
                                {{ __('Free') }}
                            @endif
                        </span>
                    </div>

                    <div class="summary-row total-row">
                        <span class="label">{{ __('Total') }}</span>
                        <span class="val">${{ number_format($total, 2) }}</span>
                    </div>

                    <a href="{{ route("checkout.index") }}" class="checkout-btn">
                        {{ __('Proceed to Checkout') }}
                    </a>

                    <div class="secure-note">
                        <svg viewBox="0 0 24 24" stroke-width="1.5"
                             stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                            <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                        </svg>
                        {{ __('Secure checkout') }}
                    </div>

                </div>
            </div>

        @endif

    </div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var flash = document.getElementById('cartFlash');
        if (flash) {
            setTimeout(function () {
                flash.style.transition = 'opacity 0.4s';
                flash.style.opacity    = '0';
                setTimeout(function () { flash.remove(); }, 400);
            }, 3500);
        }
    });
</script>
@endpush