@extends('layouts.customer.app')

@section('title', __('Shop'))

@push('styles')
    <style>
        .shop-hero {
            padding: 56px 32px 40px;
            text-align: center;
            border-bottom: 1px solid var(--border);
        }

        .shop-eyebrow {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            margin-bottom: 12px;
        }

        .shop-title {
            font-family: 'Georgia', serif;
            font-size: 34px;
            color: var(--text-primary);
            font-weight: 400;
            margin-bottom: 12px;
        }

        .shop-rule {
            width: 36px;
            height: 1px;
            background: var(--gold);
            margin: 0 auto 14px;
            opacity: 0.5;
        }

        .shop-desc {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            max-width: 480px;
            margin: 0 auto;
            line-height: 1.7;
        }

        .breadcrumb-bar {
            max-width: 1440px;
            margin: 0 auto;
            padding: 14px 32px;
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            letter-spacing: 0.5px;
        }

        .breadcrumb-bar a {
            color: var(--text-muted);
            text-decoration: none;
        }

        .breadcrumb-bar a:hover {
            color: var(--gold);
        }

        .breadcrumb-bar span {
            color: var(--gold-dim);
        }

        .shop-layout {
            max-width: 1440px;
            margin: 0 auto;
            padding: 32px 32px 80px;
            display: grid;
            grid-template-columns: 240px 1fr;
            gap: 32px;
        }

        .filters {
            position: sticky;
            top: 90px;
            align-self: start;
        }

        .filters form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .filter-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
        }

        .filter-title {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .filter-clear {
            font-size: 10px;
            color: var(--text-muted);
            text-decoration: none;
            letter-spacing: 0.5px;
            text-transform: none;
            transition: color 0.2s;
        }

        .filter-clear:hover {
            color: var(--gold);
        }

        .filter-option {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 0;
            cursor: pointer;
            font-size: 13px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
        }

        .filter-option input[type="checkbox"],
        .filter-option input[type="radio"] {
            width: 14px;
            height: 14px;
            accent-color: var(--gold);
            cursor: pointer;
            flex-shrink: 0;
        }

        .filter-option-count {
            margin-left: auto;
            font-size: 11px;
            color: var(--text-muted);
        }

        [dir="rtl"] .filter-option-count {
            margin-left: 0;
            margin-right: auto;
        }

        .price-range-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 14px;
        }

        .price-input {
            flex: 1;
            min-width: 0;
            background: #0f0f0f;
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 8px 10px;
            color: var(--text-primary);
            font-size: 12px;
            font-family: Arial, sans-serif;
            outline: none;
            box-sizing: border-box;
        }

        .price-input:focus {
            border-color: var(--gold-dim);
        }

        .price-sep {
            color: var(--text-muted);
            font-size: 12px;
        }

        .rating-stars {
            color: var(--gold);
            font-size: 13px;
            letter-spacing: 1px;
        }

        .rating-stars .dim {
            color: var(--text-muted);
        }

        .filter-submit-btn {
            width: 100%;
            padding: 13px 16px;
            background: var(--gold);
            color: #0a0a0a;
            border: none;
            border-radius: 8px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 2px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: opacity 0.2s, transform 0.15s;
        }

        .filter-submit-btn:hover {
            opacity: 0.9;
        }

        .filter-submit-btn:active {
            transform: translateY(1px);
        }

        .shop-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }

        .results-count {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
        }

        .results-count span {
            color: var(--gold);
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .sort-select {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 9px 32px 9px 14px;
            color: var(--text-secondary);
            font-size: 12px;
            font-family: Arial, sans-serif;
            outline: none;
            cursor: pointer;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%239a8870' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }

        [dir="rtl"] .sort-select {
            background-position: left 12px center;
            padding: 9px 14px 9px 32px;
        }

        .sort-select option {
            background: #111;
            color: var(--text-primary);
        }

        .view-toggle {
            display: flex;
            gap: 2px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 2px;
        }

        .view-btn {
            width: 30px;
            height: 30px;
            border: none;
            background: none;
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            cursor: pointer;
            transition: all 0.15s;
        }

        .view-btn.active {
            background: rgba(200, 169, 106, 0.12);
            color: var(--gold);
        }

        .view-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        .mobile-filter-btn {
            display: none;
            align-items: center;
            gap: 8px;
            padding: 9px 16px;
            margin-bottom: 16px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-secondary);
            font-size: 12px;
            font-family: Arial, sans-serif;
            cursor: pointer;
        }

        .mobile-filter-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        .products-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        @media (min-width: 1300px) {
            .products-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        .product-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
            display: block;
            text-decoration: none;
            position: relative;
            transition: border-color 0.2s, transform 0.2s;
        }

        .product-card:hover {
            border-color: var(--border-strong);
            transform: translateY(-3px);
        }

        .card-img {
            height: 220px;
            background: linear-gradient(135deg, rgba(200, 169, 106, 0.08), rgba(200, 169, 106, 0.02));
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 64px;
            position: relative;
            overflow: hidden;
        }

        .card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .card-img.out-of-stock {
            opacity: 0.55;
        }

        .card-tag {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: Arial, sans-serif;
            z-index: 2;
        }

        [dir="rtl"] .card-tag {
            left: auto;
            right: 10px;
        }

        .tag-new {
            background: var(--gold);
            color: #0a0a0a;
        }

        .tag-sale {
            background: var(--danger);
            color: #fff;
        }

        /* ── WISHLIST BUTTON ── */
        .wl-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            z-index: 10;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: rgba(10, 10, 10, 0.7);
            border: 1px solid rgba(200, 169, 106, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s, border-color 0.2s, transform 0.15s;
        }

        [dir="rtl"] .wl-btn {
            right: auto;
            left: 10px;
        }

        .wl-btn svg {
            width: 14px;
            height: 14px;
            stroke: var(--text-secondary);
            fill: none;
            transition: stroke 0.2s, fill 0.2s;
            pointer-events: none;
        }

        .wl-btn:hover {
            background: rgba(200, 169, 106, 0.15);
            border-color: var(--gold-dim);
            transform: scale(1.1);
        }

        .wl-btn:hover svg {
            stroke: var(--gold);
        }

        .wl-btn.active {
            background: rgba(200, 169, 106, 0.2);
            border-color: var(--gold);
        }

        .wl-btn.active svg {
            stroke: var(--gold);
            fill: var(--gold);
        }

        /* ── CARD OVERLAY ── */
        .card-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 10px 12px;
            background: linear-gradient(to top, rgba(10, 10, 10, 0.92) 0%, transparent 100%);
            transform: translateY(100%);
            transition: transform 0.25s ease;
        }

        .product-card:hover .card-overlay {
            transform: translateY(0);
        }

        /* ── ADD TO CART FORM inside overlay ── */
        .atc-form {
            margin: 0;
            padding: 0;
            width: 100%;
        }

        .btn-atc {
            width: 100%;
            padding: 9px;
            background: var(--gold);
            border: none;
            border-radius: 6px;
            color: #0a0a0a;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            display: block;
        }

        .btn-atc:hover {
            background: var(--gold-light);
        }

        .card-body {
            padding: 14px 16px 16px;
        }

        .card-cat {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            margin-bottom: 5px;
        }

        .card-name {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 8px;
            line-height: 1.4;
            font-family: Arial, sans-serif;
        }

        .card-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 12px;
        }

        .card-stars {
            color: var(--gold);
            font-size: 11px;
            letter-spacing: 1px;
        }

        .card-stars .dim {
            color: var(--text-muted);
        }

        .review-count {
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .price-now {
            font-size: 17px;
            color: var(--gold);
            font-family: Arial, sans-serif;
        }

        .price-old {
            font-size: 11px;
            color: var(--text-muted);
            text-decoration: line-through;
            margin-left: 6px;
            font-family: Arial, sans-serif;
        }

        [dir="rtl"] .price-old {
            margin-left: 0;
            margin-right: 6px;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 10px;
            font-family: Arial, sans-serif;
            letter-spacing: 0.3px;
        }

        .stock-badge::before {
            content: '';
            display: inline-block;
            width: 5px;
            height: 5px;
            border-radius: 50%;
        }

        .stock-badge.in-stock {
            color: var(--success);
        }

        .stock-badge.in-stock::before {
            background: var(--success);
        }

        .stock-badge.out-stock {
            color: var(--danger);
        }

        .stock-badge.out-stock::before {
            background: var(--danger);
        }

        .stock-badge.low-stock {
            color: var(--gold);
        }

        .stock-badge.low-stock::before {
            background: var(--gold);
        }

        .empty-state {
            text-align: center;
            padding: 80px 20px;
            grid-column: 1 / -1;
        }

        .empty-icon {
            font-size: 48px;
            margin-bottom: 16px;
            opacity: 0.4;
        }

        .empty-title {
            font-family: 'Georgia', serif;
            font-size: 18px;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        /* ── CART SUCCESS FLASH ── */
        .cart-flash {
            position: fixed;
            bottom: 28px;
            right: 28px;
            z-index: 9999;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 14px 20px;
            font-size: 13px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: slideUp 0.25s ease forwards;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(12px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .shop-pagination {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 4px;
            margin-top: 48px;
        }

        .page-btn {
            min-width: 36px;
            height: 36px;
            padding: 0 12px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-secondary);
            font-size: 12px;
            font-family: Arial, sans-serif;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.15s;
        }

        .page-btn:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
        }

        .page-btn.active {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200, 169, 106, 0.1);
            font-weight: 700;
        }

        .page-btn.dots {
            border: none;
            background: none;
            cursor: default;
        }

        .page-btn.dots:hover {
            color: var(--text-secondary);
        }

        .page-btn svg {
            width: 13px;
            height: 13px;
            stroke: currentColor;
            fill: none;
        }

        @media (max-width: 900px) {
            .shop-layout {
                grid-template-columns: 1fr;
            }

            .filters {
                display: none;
                position: static;
            }

            .filters.mobile-open {
                display: block;
            }

            .mobile-filter-btn {
                display: flex;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 560px) {
            .products-grid {
                grid-template-columns: 1fr;
            }

            .shop-toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .toolbar-right {
                justify-content: space-between;
            }

            .shop-layout {
                padding: 16px 16px 60px;
            }

            .breadcrumb-bar {
                padding: 12px 16px;
            }
        }
    </style>
@endpush

@section('content')

    {{-- ── CART SUCCESS FLASH MESSAGE ── --}}
    @if(session('cart_success'))
        <div class="cart-flash" id="cartFlash">
            <span style="width:7px;height:7px;border-radius:50%;background:var(--gold);flex-shrink:0;"></span>
            {{ session('cart_success') }}
        </div>
    @endif

    {{-- Breadcrumb --}}
    <div class="breadcrumb-bar">
        <a href="{{ route('home') }}">{{ __('Home') }}</a> / <span>{{ __('Shop') }}</span>
    </div>

    {{-- Hero --}}
    <div class="shop-hero">
        <div class="shop-eyebrow">{{ __('Our Collection') }}</div>
        <h1 class="shop-title">{{ __('Discover Your Signature Scent') }}</h1>
        <div class="shop-rule"></div>
        <p class="shop-desc">
            {{ __('Browse our full range of luxury fragrances, curated from the finest perfumers around the world.') }}
        </p>
    </div>

    <div class="shop-layout">

        {{-- ══ FILTER SIDEBAR ══ --}}
        <aside class="filters" id="filtersSidebar">
            <form action="{{ route('shop.products') }}" method="get">

                <div class="filter-card">
                    <div class="filter-title">
                        {{ __('Category') }}
                        <a href="{{ route('shop.products') }}" class="filter-clear">{{ __('Clear All') }}</a>
                    </div>
                    @foreach($categories as $cat)
                        <label class="filter-option">
                            <input type="checkbox" name="category[]" value="{{ $cat->id }}"
                                {{ in_array($cat->id, (array) request('category')) ? 'checked' : '' }}>
                            {{ $cat->getTranslation('name', app()->getLocale()) }}
                            <span class="filter-option-count">{{ $cat->products_count ?? 0 }}</span>
                        </label>
                    @endforeach
                </div>

                <div class="filter-card">
                    <div class="filter-title">{{ __('Brand') }}</div>
                    @foreach($brands as $brand)
                        <label class="filter-option">
                            <input type="checkbox" name="brand[]" value="{{ $brand->id }}"
                                {{ in_array($brand->id, (array) request('brand')) ? 'checked' : '' }}>
                            {{ $brand->getTranslation('name', app()->getLocale()) }}
                        </label>
                    @endforeach
                </div>

                <div class="filter-card">
                    <div class="filter-title">{{ __('Price Range') }}</div>
                    <div class="price-range-row">
                        <input type="number" class="price-input" name="min_price" placeholder="{{ __('Min') }}"
                            value="{{ request('min_price') }}">
                        <span class="price-sep">—</span>
                        <input type="number" class="price-input" name="max_price" placeholder="{{ __('Max') }}"
                            value="{{ request('max_price') }}">
                    </div>
                </div>

                <div class="filter-card">
                    <div class="filter-title">{{ __('Rating') }}</div>
                    @for($i = 5; $i >= 3; $i--)
                        <label class="filter-option">
                            <input type="radio" name="rating" value="{{ $i }}"
                                {{ request('rating') == $i ? 'checked' : '' }}>
                            <span class="rating-stars">
                                @for($s = 1; $s <= 5; $s++)
                                    @if($s <= $i)★@else<span class="dim">★</span>@endif
                                @endfor
                            </span>
                            {{ __('& Up') }}
                        </label>
                    @endfor
                </div>

                <div class="filter-card">
                    <div class="filter-title">{{ __('Availability') }}</div>
                    <label class="filter-option">
                        <input type="checkbox" name="in_stock" value="1" {{ request('in_stock') ? 'checked' : '' }}>
                        {{ __('In Stock') }}
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="on_sale" value="1" {{ request('on_sale') ? 'checked' : '' }}>
                        {{ __('On Sale') }}
                    </label>
                    <label class="filter-option">
                        <input type="checkbox" name="is_new" value="1" {{ request('is_new') ? 'checked' : '' }}>
                        {{ __('New Arrivals') }}
                    </label>
                </div>

                @if(request('sort'))
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                @endif

                <button type="submit" class="filter-submit-btn">{{ __('Apply Filters') }}</button>

            </form>
        </aside>

        <div>

            <button class="mobile-filter-btn" id="mobileFilterBtn" type="button">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="4" y1="21" x2="4" y2="14" />
                    <line x1="4" y1="10" x2="4" y2="3" />
                    <line x1="12" y1="21" x2="12" y2="12" />
                    <line x1="12" y1="8" x2="12" y2="3" />
                    <line x1="20" y1="21" x2="20" y2="16" />
                    <line x1="20" y1="12" x2="20" y2="3" />
                    <line x1="1" y1="14" x2="7" y2="14" />
                    <line x1="9" y1="8" x2="15" y2="8" />
                    <line x1="17" y1="16" x2="23" y2="16" />
                </svg>
                {{ __('Filters') }}
            </button>

            <div class="shop-toolbar">
                <div class="results-count">
                    @if($products->total() > 0)
                        {{ __('Showing') }}
                        <span>{{ $products->firstItem() }}–{{ $products->lastItem() }}</span>
                        {{ __('of') }}
                        <span>{{ $products->total() }}</span>
                        {{ __('fragrances') }}
                    @else
                        {{ __('No fragrances found') }}
                    @endif
                </div>
                <div class="toolbar-right">
                    <select class="sort-select" id="sortSelect">
                        <option value="" {{ !request('sort') ? 'selected' : '' }}>{{ __('Sort: Featured') }}</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                            {{ __('Price: Low to High') }}</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                            {{ __('Price: High to Low') }}</option>
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>
                            {{ __('Newest First') }}</option>
                        <option value="top_rated" {{ request('sort') == 'top_rated' ? 'selected' : '' }}>
                            {{ __('Top Rated') }}</option>
                    </select>
                    <div class="view-toggle">
                        <button class="view-btn active" id="viewGrid" type="button"
                            aria-label="{{ __('Grid view') }}">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <rect x="3" y="3" width="7" height="7" />
                                <rect x="14" y="3" width="7" height="7" />
                                <rect x="3" y="14" width="7" height="7" />
                                <rect x="14" y="14" width="7" height="7" />
                            </svg>
                        </button>
                        <button class="view-btn" id="viewList" type="button"
                            aria-label="{{ __('List view') }}">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <line x1="8" y1="6" x2="21" y2="6" />
                                <line x1="8" y1="12" x2="21" y2="12" />
                                <line x1="8" y1="18" x2="21" y2="18" />
                                <line x1="3" y1="6" x2="3.01" y2="6" />
                                <line x1="3" y1="12" x2="3.01" y2="12" />
                                <line x1="3" y1="18" x2="3.01" y2="18" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <div class="products-grid" id="productsGrid">

                @forelse($products as $product)
                    @php
                        $locale       = app()->getLocale();
                        $productName  = $product->getTranslation('name', $locale);
                        $hasSale      = !is_null($product->sale_price);
                        $displayPrice = $hasSale ? $product->sale_price : $product->price;
                        $rating       = round($product->reviews_avg_rating ?? 0);
                        $reviewCount  = $product->reviews_count ?? 0;
                        $isOutOfStock = $product->is_out_of_stock ?? false;
                        $isNew        = $product->is_new ?? false;
                        $wishlistIds  = session('wishlist', []);
                        $inWishlist   = in_array($product->id, $wishlistIds);
                        $cart=session('cart',[]);
                    @endphp

                    {{--
                        The whole card is wrapped in a <div> NOT an <a> tag,
                        because we now have a real <form> inside it.
                        Nested interactive elements inside <a> cause broken behaviour.
                        The card-link <a> sits inside instead.
                    --}}
                    <div class="product-card">

                        {{-- IMAGE AREA --}}
                        <div class="card-img {{ $isOutOfStock ? 'out-of-stock' : '' }}">

                            <a href="{{ route('store.products.show', $product->slug) }}"
                               style="display:block;width:100%;height:100%;position:absolute;inset:0;z-index:1;"
                               aria-label="{{ $productName }}">
                            </a>

                            @if($product->images)
                                <img src="{{ asset('storage/' . $product->images) }}"
                                     alt="{{ $productName }}" loading="lazy">
                            @else
                                <span aria-hidden="true">🧴</span>
                            @endif

                            @if($isNew && !$hasSale)
                                <span class="card-tag tag-new">{{ __('New') }}</span>
                            @elseif($hasSale)
                                <span class="card-tag tag-sale">{{ __('Sale') }}</span>
                            @endif

                            {{-- WISHLIST BUTTON --}}
                            <button type="button" class="wl-btn {{ $inWishlist ? 'active' : '' }}"
                                data-product-id="{{ $product->id }}"
                                aria-label="{{ $inWishlist ? __('Remove from wishlist') : __('Add to wishlist') }}"
                                aria-pressed="{{ $inWishlist ? 'true' : 'false' }}"
                                style="z-index:10;">
                                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                                     stroke-linejoin="round" aria-hidden="true">
                                    <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                                </svg>
                            </button>

                            {{-- Hidden form for wishlist AJAX --}}
                            <form class="wl-form" data-product-id="{{ $product->id }}" method="POST"
                                  action="{{ route('wishlist.toggle', $product->id) }}"
                                  style="display:none;">
                                @csrf
                            </form>
                            



@if(!$isOutOfStock)
    @if(!isset($cart[$product->id]))

        <div class="card-overlay" style="z-index:5;">
            <form method="POST" action="{{ route('add.to.cart', $product->id) }}">
                @csrf
                <button type="submit" class="btn-atc">
                    {{ __('Add to Cart') }}
                </button>
            </form>
        </div>
    @else
    <span class="stock-badge in-stock">
        {{ __('Already In Cart') }}
    </span>
@endif
@endif              </div>

                        {{-- CARD BODY (links to product page) --}}
                        <a href="{{ route('store.products.show', $product->slug) }}"
                           class="card-body" style="display:block;text-decoration:none;">

                            @if($product->category)
                                <div class="card-cat">
                                    {{ $product->category->getTranslation('name', $locale) }}
                                </div>
                            @endif

                            <div class="card-name">{{ $productName }}</div>

                            <div class="card-rating">
                                <span class="card-stars"
                                      aria-label="{{ $rating }} {{ __('out of 5 stars') }}"
                                      role="img">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $rating)
                                            <span aria-hidden="true">★</span>
                                        @else
                                            <span class="dim" aria-hidden="true">★</span>
                                        @endif
                                    @endfor
                                </span>
                                <span class="review-count">({{ number_format($reviewCount) }})</span>
                            </div>

                            <div class="card-footer">
                                <div>
                                    <span class="price-now">${{ number_format($displayPrice, 2) }}</span>
                                    @if($hasSale)
                                        <span class="price-old">${{ number_format($product->price, 2) }}</span>
                                    @endif
                                </div>

                                @if($isOutOfStock)
                                    <span class="stock-badge out-stock">{{ __('Out of Stock') }}</span>
                                @elseif(isset($product->stock_quantity) && $product->stock_quantity <= ($product->low_stock_threshold ?? 5))
                                    <span class="stock-badge low-stock">{{ __('Low Stock') }}</span>
                                @else
                                    <span class="stock-badge in-stock">{{ __('In Stock') }}</span>
                                @endif
                            </div>

                        </a>

                    </div>{{-- /.product-card --}}

                @empty
                    <div class="empty-state">
                        <div class="empty-icon">🔍</div>
                        <div class="empty-title">{{ __('No fragrances found') }}</div>
                        <div class="empty-sub">{{ __('Try adjusting your filters or search terms.') }}</div>
                    </div>
                @endforelse

            </div>

            {{-- PAGINATION --}}
            @if($products->hasPages())
                <div class="shop-pagination">

                    @if($products->onFirstPage())
                        <span class="page-btn" style="opacity:.35; cursor:not-allowed;">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $products->previousPageUrl() }}" class="page-btn"
                           aria-label="{{ __('Previous page') }}">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="15 18 9 12 15 6" />
                            </svg>
                        </a>
                    @endif

                    @php
                        $current = $products->currentPage();
                        $last    = $products->lastPage();
                        $start   = max(1, $current - 1);
                        $end     = min($last, $current + 1);
                    @endphp

                    @if($start > 1)
                        <a href="{{ $products->url(1) }}" class="page-btn">1</a>
                        @if($start > 2)<span class="page-btn dots">…</span>@endif
                    @endif

                    @for($page = $start; $page <= $end; $page++)
                        <a href="{{ $products->url($page) }}"
                           class="page-btn {{ $page == $current ? 'active' : '' }}"
                           aria-current="{{ $page == $current ? 'page' : 'false' }}">
                            {{ $page }}
                        </a>
                    @endfor

                    @if($end < $last)
                        @if($end < $last - 1)<span class="page-btn dots">…</span>@endif
                        <a href="{{ $products->url($last) }}" class="page-btn">{{ $last }}</a>
                    @endif

                    @if($products->hasMorePages())
                        <a href="{{ $products->nextPageUrl() }}" class="page-btn"
                           aria-label="{{ __('Next page') }}">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </a>
                    @else
                        <span class="page-btn" style="opacity:.35; cursor:not-allowed;">
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <polyline points="9 18 15 12 9 6" />
                            </svg>
                        </span>
                    @endif

                </div>
            @endif

        </div>

    </div>

    {{-- Toast for wishlist --}}
    <div id="wlToast" style="
            position:fixed; bottom:28px; right:28px; z-index:9999;
            background:var(--bg-card); border:1px solid var(--border);
            border-radius:8px; padding:14px 20px;
            font-size:13px; color:var(--text-primary); font-family:Arial,sans-serif;
            display:flex; align-items:center; gap:10px;
            opacity:0; transform:translateY(12px);
            transition:opacity .25s, transform .25s;
            pointer-events:none;">
        <span style="width:7px;height:7px;border-radius:50%;background:var(--gold);flex-shrink:0;"></span>
        <span id="wlToastMsg"></span>
    </div>

@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const CSRF = document.querySelector('meta[name="csrf-token"]')?.content;

            // ── AUTO-HIDE CART FLASH ──
            var cartFlash = document.getElementById('cartFlash');
            if (cartFlash) {
                setTimeout(function () {
                    cartFlash.style.transition = 'opacity 0.4s';
                    cartFlash.style.opacity = '0';
                    setTimeout(function () { cartFlash.remove(); }, 400);
                }, 3000);
            }

            // ── TOAST (used only by wishlist) ──
            function showToast(msg) {
                var toast  = document.getElementById('wlToast');
                var msgEl  = document.getElementById('wlToastMsg');
                msgEl.textContent = msg;
                toast.style.opacity   = '1';
                toast.style.transform = 'translateY(0)';
                clearTimeout(toast._timer);
                toast._timer = setTimeout(function () {
                    toast.style.opacity   = '0';
                    toast.style.transform = 'translateY(12px)';
                }, 2800);
            }

            // ── WISHLIST TOGGLE (AJAX) ──
            document.querySelectorAll('.wl-btn').forEach(function (btn) {
                btn.addEventListener('click', function (e) {
                    e.preventDefault();
                    e.stopPropagation();

                    var productId = this.dataset.productId;
                    var form = document.querySelector('.wl-form[data-product-id="' + productId + '"]');
                    if (!form || !CSRF) return;

                    btn.disabled = true;

                    fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': CSRF,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(function (r) {
                        if (!r.ok) throw new Error('HTTP ' + r.status);
                        return r.json();
                    })
                    .then(function (data) {
                        if (data.success) {
                            var active = data.in_wishlist;
                            btn.classList.toggle('active', active);
                            btn.setAttribute('aria-pressed', active ? 'true' : 'false');
                            btn.setAttribute('aria-label', active
                                ? '{{ addslashes(__("Remove from wishlist")) }}'
                                : '{{ addslashes(__("Add to wishlist")) }}'
                            );
                            document.querySelectorAll('[data-wishlist-count]').forEach(function (el) {
                                el.textContent  = data.count;
                                el.style.display = data.count > 0 ? '' : 'none';
                            });
                            showToast(data.message);
                        }
                    })
                    .catch(function () {
                        showToast('{{ addslashes(__("Something went wrong, please try again.")) }}');
                    })
                    .finally(function () { btn.disabled = false; });
                });
            });

            // ── SORT DROPDOWN ──
            var sortSelect = document.getElementById('sortSelect');
            if (sortSelect) {
                sortSelect.addEventListener('change', function () {
                    var url = new URL(window.location.href);
                    url.searchParams.delete('page');
                    if (this.value) {
                        url.searchParams.set('sort', this.value);
                    } else {
                        url.searchParams.delete('sort');
                    }
                    window.location.href = url.toString();
                });
            }

            // ── MOBILE FILTER TOGGLE ──
            var mobileBtn = document.getElementById('mobileFilterBtn');
            var sidebar   = document.getElementById('filtersSidebar');
            if (mobileBtn && sidebar) {
                mobileBtn.addEventListener('click', function () {
                    sidebar.classList.toggle('mobile-open');
                });
            }

            // ── GRID / LIST VIEW TOGGLE ──
            var viewGrid = document.getElementById('viewGrid');
            var viewList = document.getElementById('viewList');
            var grid     = document.getElementById('productsGrid');
            if (viewGrid && viewList && grid) {
                viewGrid.addEventListener('click', function () {
                    viewGrid.classList.add('active');
                    viewList.classList.remove('active');
                    grid.style.gridTemplateColumns = '';
                });
                viewList.addEventListener('click', function () {
                    viewList.classList.add('active');
                    viewGrid.classList.remove('active');
                    grid.style.gridTemplateColumns = '1fr';
                });
            }

            // ── PRICE FILTER — disable empty inputs before submit ──
            var filterForm = document.querySelector('#filtersSidebar form');
            if (filterForm) {
                filterForm.addEventListener('submit', function () {
                    this.querySelectorAll('input[type="number"]').forEach(function (input) {
                        if (input.value.trim() === '') input.disabled = true;
                    });
                });
            }

        });
    </script>
@endpush