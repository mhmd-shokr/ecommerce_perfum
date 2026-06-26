{{-- resources/views/customer/checkout.blade.php --}}
@extends('layouts.customer.app')

@section('title', __('Checkout'))

@push('styles')
    <style>
        .checkout-breadcrumb {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 32px;
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .checkout-breadcrumb a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .checkout-breadcrumb a:hover {
            color: var(--gold);
        }

        .checkout-breadcrumb span {
            color: var(--gold-dim);
        }

        .checkout-hero {
            text-align: center;
            padding: 40px 32px 32px;
            border-bottom: 1px solid var(--border);
        }

        .checkout-eyebrow {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            margin-bottom: 10px;
        }

        .checkout-title {
            font-family: 'Georgia', serif;
            font-size: 30px;
            font-weight: 400;
            color: var(--text-primary);
        }

        .checkout-rule {
            width: 36px;
            height: 1px;
            background: var(--gold);
            opacity: 0.5;
            margin: 10px auto 0;
        }

        /* Layout */
        .checkout-layout {
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 32px 80px;
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 32px;
            align-items: start;
        }

        /* Flash */
        .checkout-flash {
            max-width: 1200px;
            margin: 20px auto 0;
            padding: 0 32px;
        }

        .flash-error {
            display: flex;
            align-items: center;
            gap: 10px;
            background: rgba(196, 80, 64, 0.08);
            border: 1px solid rgba(196, 80, 64, 0.3);
            border-radius: 8px;
            padding: 12px 18px;
            font-size: 13px;
            color: var(--danger);
            font-family: Arial, sans-serif;
        }

        /* Section Card */
        .c-section {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .c-section-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .c-section-header svg {
            width: 14px;
            height: 14px;
            stroke: var(--gold-dim);
            fill: none;
        }

        .c-section-body {
            padding: 24px;
        }

        /* Address tabs */
        .address-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 20px;
        }

        .address-tab {
            padding: 8px 16px;
            border: 1px solid var(--border);
            border-radius: 6px;
            font-size: 11px;
            font-family: Arial, sans-serif;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: var(--text-muted);
            background: transparent;
            cursor: pointer;
            transition: all 0.15s;
        }

        .address-tab.active {
            border-color: var(--gold-dim);
            color: var(--gold);
            background: rgba(200, 169, 106, 0.08);
        }

        /* Saved addresses */
        .saved-addresses {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .saved-address-card {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            padding: 14px 16px;
            border: 1px solid var(--border);
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.15s;
        }

        .saved-address-card:hover {
            border-color: var(--gold-dim);
        }

        .saved-address-card.selected {
            border-color: var(--gold);
            background: rgba(200, 169, 106, 0.05);
        }

        .saved-address-card input[type="radio"] {
            margin-top: 3px;
            accent-color: var(--gold);
        }

        .saved-address-info {
            font-family: Arial, sans-serif;
        }

        .saved-address-name {
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 3px;
        }

        .saved-address-detail {
            font-size: 12px;
            color: var(--text-muted);
            line-height: 1.6;
        }

        /* Form */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 16px;
        }

        .form-row.full {
            grid-template-columns: 1fr;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        .form-label {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
        }

        .form-control {
            background: rgba(200, 169, 106, 0.04);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 10px 14px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: Arial, sans-serif;
            outline: none;
            transition: border-color 0.15s;
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--gold-dim);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-error {
            font-size: 11px;
            color: var(--danger);
            font-family: Arial, sans-serif;
        }

        /* Order Summary */
        .order-summary {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            position: sticky;
            top: 90px;
        }

        .summary-header {
            padding: 16px 24px;
            border-bottom: 1px solid var(--border);
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
        }

        .summary-body {
            padding: 20px 24px;
        }

        /* Cart Items in summary */
        .summary-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid var(--border);
        }

        .summary-item:last-of-type {
            border-bottom: none;
        }

        .summary-item-img {
            width: 48px;
            height: 48px;
            border-radius: 6px;
            object-fit: cover;
            background: rgba(200, 169, 106, 0.06);
            border: 1px solid var(--border);
            flex-shrink: 0;
        }

        .summary-item-info {
            flex: 1;
        }

        .summary-item-name {
            font-size: 12px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
        }

        .summary-item-qty {
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .summary-item-price {
            font-size: 13px;
            color: var(--gold);
            font-family: Arial, sans-serif;
        }

        .summary-divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 16px 0;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
            font-size: 13px;
            font-family: Arial, sans-serif;
        }

        .summary-row .label {
            color: var(--text-secondary);
        }

        .summary-row .val {
            color: var(--text-primary);
        }

        .summary-row.total-row {
            margin-top: 10px;
            padding-top: 14px;
            border-top: 1px solid var(--border);
        }

        .summary-row.total-row .label {
            font-size: 14px;
            color: var(--text-primary);
            font-weight: 600;
        }

        .summary-row.total-row .val {
            font-size: 20px;
            color: var(--gold);
            font-weight: 700;
        }

        .place-order-btn {
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
            cursor: pointer;
            transition: opacity 0.2s;
            margin-top: 20px;
        }

        .place-order-btn:hover {
            opacity: 0.88;
        }

        .place-order-btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

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

        .secure-note svg {
            width: 12px;
            height: 12px;
            stroke: currentColor;
            fill: none;
        }

        @media (max-width: 900px) {
            .checkout-layout {
                grid-template-columns: 1fr;
                padding: 24px 16px 60px;
            }

            .order-summary {
                position: static;
            }

            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Breadcrumb --}}
    <div class="checkout-breadcrumb">
        <a href="{{ route('home') }}">{{ __('Home') }}</a> /
        <a href="{{ route('cart.index') }}">{{ __('Cart') }}</a> /
        <span>{{ __('Checkout') }}</span>
    </div>

    {{-- Hero --}}
    <div class="checkout-hero">
        <div class="checkout-eyebrow">{{ __('Almost There') }}</div>
        <h1 class="checkout-title">{{ __('Checkout') }}</h1>
        <div class="checkout-rule"></div>
    </div>

    {{-- Flash Error --}}
    @if(session('error'))
        <div class="checkout-flash">
            <div class="flash-error">⚠ {{ session('error') }}</div>
        </div>
    @endif

    <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
        @csrf
        <div class="checkout-layout">

            {{-- ══ LEFT: Address + Shipping ══ --}}
            <div>

                {{-- Address Section --}}
                <div class="c-section">
                    <div class="c-section-header">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z" />
                            <circle cx="12" cy="10" r="3" />
                        </svg>
                        {{ __('Delivery Address') }}
                    </div>
                    <div class="c-section-body">

                        {{-- Tabs: Saved / New --}}
                        <div class="address-tabs">
                            @if($addresses->isNotEmpty())
                                <button type="button" class="address-tab active" id="tab-saved" onclick="showTab('saved')">
                                    {{ __('Saved Addresses') }}
                                </button>
                            @endif
                            <button type="button" class="address-tab {{ $addresses->isEmpty() ? 'active' : '' }}"
                                id="tab-new" onclick="showTab('new')">
                                {{ __('New Address') }}
                            </button>
                        </div>

                        {{-- Saved Addresses --}}
                        @if($addresses->isNotEmpty())
                            <div id="panel-saved">
                                <div class="saved-addresses">
                                    @foreach($addresses as $address)
                                        <label class="saved-address-card {{ $loop->first ? 'selected' : '' }}">
                                            <input type="radio" name="address_id" value="{{ $address->id }}"
                                                data-governorate="{{ $address->governorate }}" {{ $loop->first ? 'checked' : '' }}
                                                onchange="
                                                                        document.querySelectorAll('.saved-address-card')
                                                                            .forEach(c => c.classList.remove('selected'));
                                                                        this.closest('.saved-address-card').classList.add('selected');
                                                                        updateShipping(this.dataset.governorate)
                                                                    ">
                                            <div class="saved-address-info">
                                                <div class="saved-address-name">
                                                    {{ $address->full_name }} — {{ $address->phone }}
                                                </div>
                                                <div class="saved-address-detail">
                                                    {{ $address->street }},
                                                    @if($address->building) {{ __('Building') }} {{ $address->building }}, @endif
                                                    @if($address->floor) {{ __('Floor') }} {{ $address->floor }}, @endif
                                                    {{ $address->city }}, {{ $address->governorate }}
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        {{-- New Address Form --}}
                        <div id="panel-new" style="{{ $addresses->isNotEmpty() ? 'display:none' : '' }}">
                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Full Name') }} *</label>
                                    <input type="text" name="full_name" class="form-control"
                                        placeholder="{{ __('Ahmed Mohamed') }}" value="{{ old('full_name') }}">
                                    @error('full_name')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('Phone') }} *</label>
                                    <input type="text" name="phone" class="form-control" placeholder="01XXXXXXXXX"
                                        value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Governorate') }} *</label>
                                    <select name="governorate" class="form-control" onchange="updateShipping(this.value)">
                                        <option value="">{{ __('Select Governorate') }}</option>
                                        @foreach($shippingZones as $zone)
                                            <option value="{{ $zone->governorate }}" {{ old('governorate') == $zone->governorate ? 'selected' : '' }}>
                                                {{ $zone->governorate }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('governorate')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('City') }} *</label>
                                    <input type="text" name="city" class="form-control" placeholder="{{ __('Cairo') }}"
                                        value="{{ old('city') }}">
                                    @error('city')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row full">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Street') }} *</label>
                                    <input type="text" name="street" class="form-control"
                                        placeholder="{{ __('Street name and number') }}" value="{{ old('street') }}">
                                    @error('street')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Building') }}</label>
                                    <input type="text" name="building" class="form-control"
                                        placeholder="{{ __('Optional') }}" value="{{ old('building') }}">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('Floor') }}</label>
                                    <input type="text" name="floor" class="form-control" placeholder="{{ __('Optional') }}"
                                        value="{{ old('floor') }}">
                                </div>
                            </div>

                            <div class="form-row full">
                                <div class="form-group">
                                    <label class="form-label">{{ __('Notes') }}</label>
                                    <textarea name="notes" class="form-control" rows="2"
                                        placeholder="{{ __('Additional delivery notes...') }}">{{ old('notes') }}</textarea>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                {{-- Payment Method --}}
                <div class="c-section">
                    <div class="c-section-header">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="1" y="4" width="22" height="16" rx="2" ry="2" />
                            <line x1="1" y1="10" x2="23" y2="10" />
                        </svg>
                        {{ __('Payment Method') }}
                    </div>
                    <div class="c-section-body">
                        <label class="saved-address-card selected">
                            <input type="radio" name="payment_method" value="cash" checked>
                            <div class="saved-address-info">
                                <div class="saved-address-name">💵 {{ __('Cash on Delivery') }}</div>
                                <div class="saved-address-detail">
                                    {{ __('Pay when your order arrives') }}
                                </div>
                            </div>
                        </label>
                    </div>
                </div>

            </div>

            {{-- ══ RIGHT: Order Summary ══ --}}
            <div class="order-summary">
                <div class="summary-header">{{ __('Order Summary') }}</div>
                <div class="summary-body">

                    {{-- Cart Items --}}
                    @foreach($cartItems as $item)
                        @php
                            $price = $item->product->sale_price ?? $item->product->price;
                        @endphp
                        <div class="summary-item">
                            @if($item->product->images)
                                <img src="{{ asset('storage/' . $item->product->images) }}"
                                    alt="{{ $item->product->getTranslation('name', app()->getLocale()) }}" class="summary-item-img">
                            @else
                                <div class="summary-item-img"
                                    style="display:flex;align-items:center;justify-content:center;font-size:22px;">🧴</div>
                            @endif
                            <div class="summary-item-info">
                                <div class="summary-item-name">
                                    {{ $item->product->getTranslation('name', app()->getLocale()) }}
                                </div>
                                <div class="summary-item-qty">× {{ $item->quantity }}</div>
                            </div>
                            <div class="summary-item-price">
                                ${{ number_format($price * $item->quantity, 2) }}
                            </div>
                        </div>
                    @endforeach

                    <hr class="summary-divider">

                    {{-- Totals --}}
                    <div class="summary-row">
                        <span class="label">{{ __('Subtotal') }}</span>
                        <span class="val">${{ number_format($subtotal, 2) }}</span>
                    </div>

                    <div class="summary-row">
                        <span class="label">{{ __('Shipping') }}</span>
                        {{-- بيتحدث بالـ AJAX لما يختار محافظة --}}
                        <span class="val" id="shipping-cost-display">
                            {{ __('Select governorate') }}
                        </span>
                    </div>

                    <div class="summary-row total-row">
                        <span class="label">{{ __('Total') }}</span>
                        <span class="val" id="total-display">
                            ${{ number_format($subtotal, 2) }}
                        </span>
                    </div>

                    <button type="submit" class="place-order-btn" id="place-order-btn">
                        {{ __('Place Order') }}
                    </button>

                    <div class="secure-note">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" />
                            <path d="M7 11V7a5 5 0 0 1 10 0v4" />
                        </svg>
                        {{ __('Secure checkout') }}
                    </div>

                </div>
            </div>

        </div>
    </form>

@endsection

@push('scripts')
    <script>
        const subtotal = {{ $subtotal }};
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // ── Tabs (Saved / New Address) ──
        function showTab(tab) {
            const isSaved = tab === 'saved';

            document.getElementById('panel-saved')?.style.setProperty('display', isSaved ? 'block' : 'none');
            document.getElementById('panel-new').style.display = isSaved ? 'none' : 'block';

            document.getElementById('tab-saved')?.classList.toggle('active', isSaved);
            document.getElementById('tab-new').classList.toggle('active', !isSaved);

            if (!isSaved) {
                document.querySelectorAll('input[name="address_id"]')
                    .forEach(r => r.checked = false);
            }
        }

        // ── AJAX: جيب تكلفة الشحن لما يختار محافظة ──
        function updateShipping(governorate) {
            if (!governorate) return;

            fetch('{{ route("checkout.shipping.cost") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: JSON.stringify({ governorate }),
            })
                .then(r => r.json())
                .then(data => {
                    const cost = parseFloat(data.cost);
                    const total = subtotal + cost;

                    document.getElementById('shipping-cost-display').textContent =
                        cost > 0 ? `$${cost.toFixed(2)}` : '{{ __("Free") }}';

                    document.getElementById('total-display').textContent =
                        `$${total.toFixed(2)}`;
                });
        }

        document.addEventListener('DOMContentLoaded', function () {
            const checked = document.querySelector('input[name="address_id"]:checked');
            if (checked) {
                updateShipping(checked.dataset.governorate);
            }
        });
    </script>
@endpush