@extends('layouts.customer.app')

@section('title', $product->getTranslation('name', app()->getLocale()))

@push('styles')
    <style>
        .breadcrumb-bar {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px 32px;
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

        .product-main {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px 60px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 56px;
        }

        /* Gallery */
        .gallery {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .gallery-main {
            aspect-ratio: 1 / 1.05;
            background: linear-gradient(135deg, rgba(200, 169, 106, 0.08), rgba(200, 169, 106, 0.03));
            border: 1px solid var(--border);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .gallery-main img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .gallery-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--gold);
            color: #0a0a0a;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 4px 10px;
            border-radius: 4px;
            font-family: Arial, sans-serif;
            z-index: 2;
        }

        [dir="rtl"] .gallery-badge {
            left: auto;
            right: 16px;
        }

        /* Product info */
        .product-info {
            display: flex;
            flex-direction: column;
        }

        .brand-name {
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            margin-bottom: 10px;
        }

        .product-title {
            font-family: 'Georgia', serif;
            font-size: 30px;
            color: var(--text-primary);
            font-weight: 400;
            margin-bottom: 12px;
            line-height: 1.25;
        }

        .rating-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .stars {
            color: var(--gold);
            font-size: 14px;
            letter-spacing: 2px;
        }

        .stars .dim {
            color: var(--text-muted);
        }

        .rating-text {
            font-size: 12px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .rating-text a {
            color: var(--gold-dim);
            text-decoration: none;
        }

        .rating-text a:hover {
            color: var(--gold);
        }

        .price-row {
            display: flex;
            align-items: baseline;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }

        .price-now {
            font-size: 32px;
            color: var(--gold);
            font-family: Arial, sans-serif;
        }

        .price-old {
            font-size: 16px;
            color: var(--text-muted);
            text-decoration: line-through;
            font-family: Arial, sans-serif;
        }

        .price-save {
            font-size: 11px;
            color: var(--success);
            background: rgba(122, 184, 122, 0.1);
            border: 1px solid rgba(122, 184, 122, 0.25);
            padding: 3px 9px;
            border-radius: 20px;
            font-family: Arial, sans-serif;
        }

        .product-desc {
            font-size: 14px;
            color: var(--text-secondary);
            line-height: 1.8;
            font-family: Arial, sans-serif;
            margin-bottom: 28px;
        }

        /* Size selector */
        .option-group {
            margin-bottom: 24px;
        }

        .option-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
        }

        .option-label .selected {
            color: var(--gold);
            text-transform: none;
            letter-spacing: 0;
            font-size: 12px;
        }

        .size-options {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .size-btn {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2px;
            padding: 8px 16px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-secondary);
            font-size: 13px;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: all 0.2s;
        }

        .size-btn-price {
            font-size: 10px;
            color: var(--text-muted);
        }

        .size-btn:hover {
            border-color: var(--gold-dim);
        }

        .size-btn.active {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200, 169, 106, 0.08);
        }

        .size-btn.active .size-btn-price {
            color: var(--gold-dim);
        }

        /* Quantity + Add to cart */
        .purchase-row {
            display: flex;
            gap: 12px;
            margin-bottom: 16px;
        }

        .qty-control {
            display: flex;
            align-items: center;
            border: 1px solid var(--border);
            border-radius: 6px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .qty-btn {
            width: 38px;
            height: 48px;
            background: var(--bg-card);
            border: none;
            color: var(--text-secondary);
            font-size: 16px;
            cursor: pointer;
            transition: color 0.2s;
        }

        .qty-btn:hover {
            color: var(--gold);
        }

        .qty-value {
            width: 40px;
            height: 48px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0f0f0f;
            color: var(--text-primary);
            font-size: 14px;
            font-family: Arial, sans-serif;
            border: none;
            border-left: 1px solid var(--border);
            border-right: 1px solid var(--border);
            text-align: center;
        }

        .btn-add-cart {
            flex: 1;
            background: var(--gold);
            border: none;
            border-radius: 6px;
            color: #0a0a0a;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            height: 48px;
        }

        .btn-add-cart:hover {
            background: var(--gold-light);
        }

        .btn-add-cart:disabled {
            opacity: 0.4;
            cursor: not-allowed;
        }

        .btn-add-cart svg {
            width: 16px;
            height: 16px;
            stroke: currentColor;
            fill: none;
        }

        .btn-wishlist {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-secondary);
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-wishlist:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
        }

        .btn-wishlist svg {
            width: 18px;
            height: 18px;
            stroke: currentColor;
            fill: none;
        }

        .btn-wishlist.active {
            border-color: var(--gold);
            color: var(--gold);
        }

        .stock-note {
            font-size: 12px;
            font-family: Arial, sans-serif;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .stock-note.in {
            color: var(--success);
        }

        .stock-note.low {
            color: var(--gold);
        }

        .stock-note.out {
            color: var(--danger);
        }

        .stock-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            flex-shrink: 0;
        }

        .trust-row {
            display: flex;
            flex-direction: column;
            gap: 12px;
            padding: 20px 0;
            border-top: 1px solid var(--border);
        }

        .trust-item {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
        }

        .trust-item svg {
            width: 16px;
            height: 16px;
            stroke: var(--gold);
            fill: none;
            flex-shrink: 0;
        }

        [dir="rtl"] .trust-item {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .purchase-row {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .price-row {
            flex-direction: row-reverse;
        }

        [dir="rtl"] .stock-note {
            flex-direction: row-reverse;
        }

        /* Accordion */
        .accordion {
            border-top: 1px solid var(--border);
            margin-top: 8px;
        }

        .accordion-item {
            border-bottom: 1px solid var(--border);
        }

        .accordion-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 16px 0;
            cursor: pointer;
            user-select: none;
        }

        .accordion-title {
            font-size: 13px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
            letter-spacing: 0.3px;
        }

        .accordion-icon {
            width: 16px;
            height: 16px;
            color: var(--text-muted);
            transition: transform 0.2s;
            stroke: currentColor;
            fill: none;
            flex-shrink: 0;
        }

        .accordion-item.open .accordion-icon {
            transform: rotate(45deg);
            color: var(--gold);
        }

        .accordion-body {
            display: none;
            padding-bottom: 16px;
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.8;
            font-family: Arial, sans-serif;
        }

        .accordion-item.open .accordion-body {
            display: block;
        }

        .notes-grid {
            display: flex;
            gap: 20px;
            margin-top: 4px;
            flex-wrap: wrap;
        }

        .note-col {
            flex: 1;
            min-width: 120px;
        }

        .note-label {
            font-size: 10px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--gold-dim);
            margin-bottom: 6px;
        }

        .note-val {
            font-size: 12px;
            color: var(--text-secondary);
        }

        /* Reviews */
        .reviews-section {
            border-top: 1px solid var(--border);
            padding-top: 24px;
            margin-top: 8px;
        }

        .review-item {
            padding: 16px 0;
            border-bottom: 1px solid rgba(200, 169, 106, 0.06);
        }

        .review-item:last-child {
            border-bottom: none;
        }

        .review-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 6px;
        }

        .review-author {
            font-size: 13px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
        }

        .review-date {
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        .review-stars {
            font-size: 12px;
            margin-bottom: 6px;
            display: block;
        }

        .star {
            color: var(--gold);
        }

        .star.dim {
            color: var(--text-muted);
        }

        .review-comment {
            font-size: 13px;
            color: var(--text-secondary);
            line-height: 1.7;
            font-family: Arial, sans-serif;
        }

        .no-reviews {
            font-size: 13px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            padding: 12px 0;
        }

        /* Write a review */
        .review-form-wrap {
            margin-top: 28px;
            padding: 24px;
            border: 1px solid var(--border);
            border-radius: 10px;
            background: var(--bg-card);
        }

        .review-form-title {
            font-size: 13px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
            letter-spacing: 0.3px;
            margin-bottom: 18px;
        }

        .review-form-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            display: block;
            margin-bottom: 8px;
        }

        .review-form-select {
            width: 100%;
            padding: 10px 12px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
            font-size: 13px;
            margin-bottom: 16px;
            appearance: none;
            cursor: pointer;
        }

        .review-form-select:focus {
            outline: none;
            border-color: var(--gold-dim);
        }

        .review-form-textarea {
            width: 100%;
            min-height: 100px;
            padding: 12px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
            font-size: 13px;
            line-height: 1.7;
            resize: vertical;
            box-sizing: border-box;
            margin-bottom: 16px;
            transition: border-color 0.2s;
        }

        .review-form-textarea:focus {
            outline: none;
            border-color: var(--gold-dim);
        }

        .review-form-textarea::placeholder {
            color: var(--text-muted);
        }

        .review-form-submit {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 44px;
            padding: 0 28px;
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
        }

        .review-form-submit:hover {
            background: var(--gold-light);
        }

        .review-login-note {
            font-size: 13px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            padding: 12px 0;
        }

        .review-login-note a {
            color: var(--gold);
            text-decoration: none;
        }

        .review-login-note a:hover {
            color: var(--gold-light);
        }

        .review-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 8px;
        }

        [dir="rtl"] .review-actions {
            justify-content: flex-start;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: transparent;
            border: 1px solid var(--border);
            border-radius: 6px;
            color: var(--text-muted);
            cursor: pointer;
            padding: 0;
            transition: all 0.2s;
        }

        .action-btn:hover {
            border-color: var(--danger);
            color: var(--danger);
        }

        .action-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 1.5;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        /* Star rating picker */
        .star-picker {
            display: flex;
            gap: 6px;
            margin-bottom: 16px;
        }

        .star-picker input[type="radio"] {
            display: none;
        }

        .star-picker label {
            font-size: 22px;
            color: var(--text-muted);
            cursor: pointer;
            transition: color 0.15s;
            line-height: 1;
        }

        .star-picker label:hover,
        .star-picker label:hover~label,
        .star-picker input[type="radio"]:checked~label {
            color: var(--text-muted);
        }

        .star-picker:hover label,
        .star-picker input[type="radio"]:checked+label {
            color: var(--gold);
        }

        /* Related products */
        .related-section {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 32px 80px;
        }

        .related-header {
            margin-bottom: 28px;
        }

        .related-title {
            font-family: 'Georgia', serif;
            font-size: 22px;
            color: var(--text-primary);
            font-weight: 400;
        }

        .related-rule {
            width: 32px;
            height: 1px;
            background: var(--gold);
            margin-top: 10px;
            opacity: 0.5;
        }

        .related-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            overflow: hidden;
            cursor: pointer;
            transition: border-color 0.2s, transform 0.2s;
            text-decoration: none;
            display: block;
        }

        .product-card:hover {
            border-color: var(--border-strong);
            transform: translateY(-2px);
        }

        .product-img {
            height: 180px;
            background: linear-gradient(135deg, rgba(200, 169, 106, 0.08), rgba(200, 169, 106, 0.03));
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--border);
            overflow: hidden;
            position: relative;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-body {
            padding: 14px;
        }

        .product-cat {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            margin-bottom: 5px;
        }

        .product-name {
            font-size: 13px;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .product-price {
            font-size: 15px;
            color: var(--gold);
            font-family: Arial, sans-serif;
        }

        .product-price-old {
            font-size: 11px;
            color: var(--text-muted);
            text-decoration: line-through;
            margin-left: 5px;
        }

        @media (max-width: 900px) {
            .product-main {
                grid-template-columns: 1fr;
                gap: 32px;
                padding: 0 16px 40px;
            }

            .breadcrumb-bar {
                padding: 12px 16px;
            }

            .related-section {
                padding: 0 16px 60px;
            }

            .related-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .purchase-row {
                flex-wrap: wrap;
            }

            .btn-add-cart {
                flex: 1 1 auto;
                min-width: 0;
            }
        }

        @media (max-width: 480px) {
            .related-grid {
                grid-template-columns: 1fr 1fr;
                gap: 12px;
            }
        }
    </style>
@endpush

@section('content')

    @php
        $locale = app()->getLocale();
        $name = $product->getTranslation('name', $locale);
        $description = $product->getTranslation('description', $locale);
        $hasSale = !is_null($product->sale_price);
        $currentPrice = $hasSale ? $product->sale_price : $product->price;
        $currencySymbol = config('shop.currency_symbol', '$');
        $isOutOfStock = $product->is_out_of_stock;
    @endphp

    {{-- Breadcrumb --}}
    <div class="breadcrumb-bar">
        <a href="{{ route('home') }}">{{ __('Home') }}</a> /
        <a href="{{ route('shop.products') }}">{{ __('Shop') }}</a>
        @if($product->category)
            / <a href="{{ route('shop.products', ['category' => $product->category->id]) }}">
                {{ $product->category->getTranslation('name', $locale) }}
            </a>
        @endif
        / <span>{{ $name }}</span>
    </div>

    <div class="product-main">

        {{-- ══ GALLERY ══ --}}
        <div class="gallery">
            <div class="gallery-main">
                @if($product->is_bestseller)
                    <span class="gallery-badge">{{ __('Best Seller') }}</span>
                @elseif($product->is_new)
                    <span class="gallery-badge">{{ __('New') }}</span>
                @endif

                @if($product->images)
                    <img src="{{ asset('storage/' . $product->images) }}" alt="{{ $name }}">
                @else
                    <span style="font-size:130px;" aria-hidden="true">🧴</span>
                @endif
            </div>
        </div>

        {{-- ══ PRODUCT INFO ══ --}}
        <div class="product-info">

            @if($product->brand)
                <div class="brand-name">{{ $product->brand->name }}</div>
            @endif

            <h1 class="product-title">{{ $name }}</h1>

            {{-- Rating --}}
            @php
                $avgRating = $product->average_rating ?? 0;
                $reviewsCount = $product->reviews_count ?? $product->reviews->count();
            @endphp
            <div class="rating-row">
                <span class="stars" aria-label="{{ number_format($avgRating, 1) }} {{ __('out of 5 stars') }}" role="img">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= round($avgRating))
                            <span aria-hidden="true">★</span>
                        @else
                            <span class="dim" aria-hidden="true">★</span>
                        @endif
                    @endfor
                </span>
                <span class="rating-text">
                    {{ number_format($avgRating, 1) }} · <a href="#reviews">{{ $reviewsCount }} {{ __('reviews') }}</a>
                </span>
            </div>

            {{-- Price --}}
            <div class="price-row">
                <span class="price-now" id="priceNow">{{ $currencySymbol }}{{ number_format($currentPrice, 2) }}</span>
                @if($hasSale)
                    <span class="price-old">{{ $currencySymbol }}{{ number_format($product->price, 2) }}</span>
                    <span class="price-save">
                        {{ __('Save') }} {{ round((($product->price - $product->sale_price) / $product->price) * 100) }}%
                    </span>
                @endif
            </div>

            @if($product->short_description)
                <p class="product-desc">{{ $product->getTranslation('short_description', $locale) }}</p>
            @else
                <p class="product-desc">{{ $description }}</p>
            @endif

            {{-- Size options --}}
            @if($product->sizes && $product->sizes->count())
                <div class="option-group">
                    <div class="option-label">
                        {{ __('Size') }}
                        <span class="selected" id="selectedSizeLabel">
                            {{ $product->sizes->first()->name ?? $product->sizes->first()->value }}
                        </span>
                    </div>
                    <div class="size-options" role="group" aria-label="{{ __('Select size') }}">
                        @foreach($product->sizes as $index => $size)
                            <button type="button" class="size-btn {{ $index === 0 ? 'active' : '' }}" data-size-id="{{ $size->id }}"
                                data-label="{{ $size->name ?? $size->value }}" aria-pressed="{{ $index === 0 ? 'true' : 'false' }}">
                                {{ $size->name ?? $size->value }}
                                @if(isset($size->price))
                                    <span class="size-btn-price">{{ $currencySymbol }}{{ number_format($size->price, 2) }}</span>
                                @endif
                            </button>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Stock note --}}
            <div
                class="stock-note {{ $product->is_out_of_stock ? 'out' : ($product->stock_quantity <= $product->low_stock_threshold ? 'low' : 'in') }}">
                <span class="stock-dot" aria-hidden="true"></span>
                @if($product->is_out_of_stock)
                    {{ __('Out of Stock') }}
                @elseif($product->stock_quantity <= $product->low_stock_threshold)
                    {{ __('Only :count left in stock', ['count' => $product->stock_quantity]) }}
                @else
                    {{ __('In Stock') }}
                @endif
            </div>

            @php
                $cart = session('cart', []);
            @endphp
            {{-- Quantity + Add to cart --}}

            @if ($isOutOfStock)
            @elseif(isset($cart[$product->id]) && !$isOutOfStock)
                <span class="stock-badge in-stock">
                    {{ __('Already In Cart') }}
                </span>

            @else
                <form method="POST" action="{{ route('add.to.cart', $product) }}">
                    @csrf
                    <input type="hidden" name="size_id" id="selectedSizeId" value="{{ $product->sizes->first()->id ?? '' }}">

                    <div class="purchase-row">
                        <div class="qty-control">
                            <button type="button" class="qty-btn" aria-label="{{ __('Decrease quantity') }}"
                                onclick="changeQty(-1)">−</button>
                            <input type="number" name="quantity" id="qty" class="qty-value" value="1" min="1"
                                max="{{ $product->stock_quantity }}" readonly aria-label="{{ __('Quantity') }}">
                            <button type="button" class="qty-btn" aria-label="{{ __('Increase quantity') }}"
                                onclick="changeQty(1)">+</button>
                        </div>
                        <button type="submit" class="btn-add-cart" {{ $product->is_out_of_stock ? 'disabled' : '' }}>
                            <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                aria-hidden="true">
                                <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                                <line x1="3" y1="6" x2="21" y2="6" />
                                <path d="M16 10a4 4 0 0 1-8 0" />
                            </svg>
                            {{ __('Add to Cart') }}
                        </button>
                </form>
            @endif

        </div>

        {{-- Trust badges --}}
        <div class="trust-row">
            <div class="trust-item">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <rect x="1" y="3" width="15" height="13" />
                    <polygon points="16 8 20 8 23 11 23 16 16 16 16 8" />
                    <circle cx="5.5" cy="18.5" r="2.5" />
                    <circle cx="18.5" cy="18.5" r="2.5" />
                </svg>
                {{ __('Free shipping on orders over :amount', ['amount' => $currencySymbol . '100']) }}
            </div>
            <div class="trust-item">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                </svg>
                {{ __('100% authentic, sealed product') }}
            </div>
            <div class="trust-item">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                    aria-hidden="true">
                    <polyline points="1 4 1 10 7 10" />
                    <path d="M3.51 15a9 9 0 1 0 2.13-9.36L1 10" />
                </svg>
                {{ __('Easy 30-day returns') }}
            </div>
        </div>

        {{-- Accordion --}}
        <div class="accordion">

            {{-- Fragrance notes --}}
            @if($product->fragranceNotes && $product->fragranceNotes->count())
                <div class="accordion-item open">
                    <div class="accordion-head" onclick="this.parentElement.classList.toggle('open')" role="button"
                        tabindex="0">
                        <span class="accordion-title">{{ __('Fragrance Notes') }}</span>
                        <svg class="accordion-icon" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                            aria-hidden="true">
                            <line x1="12" y1="5" x2="12" y2="19" />
                            <line x1="5" y1="12" x2="19" y2="12" />
                        </svg>
                    </div>
                    <div class="accordion-body">
                        <div class="notes-grid">
                            @foreach(['top' => __('Top'), 'heart' => __('Heart'), 'base' => __('Base')] as $type => $label)
                                @php $notes = $product->fragranceNotes->where('pivot.type', $type); @endphp
                                @if($notes->count())
                                    <div class="note-col">
                                        <div class="note-label">{{ $label }}</div>
                                        <div class="note-val">{{ $notes->pluck('name')->join(', ') }}</div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            {{-- Description --}}
            <div class="accordion-item">
                <div class="accordion-head" onclick="this.parentElement.classList.toggle('open')" role="button"
                    tabindex="0">
                    <span class="accordion-title">{{ __('Description') }}</span>
                    <svg class="accordion-icon" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                        aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </div>
                <div class="accordion-body">{{ $description }}</div>
            </div>

            {{-- Shipping & Returns --}}
            <div class="accordion-item">
                <div class="accordion-head" onclick="this.parentElement.classList.toggle('open')" role="button"
                    tabindex="0">
                    <span class="accordion-title">{{ __('Shipping & Returns') }}</span>
                    <svg class="accordion-icon" viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round"
                        aria-hidden="true">
                        <line x1="12" y1="5" x2="12" y2="19" />
                        <line x1="5" y1="12" x2="19" y2="12" />
                    </svg>
                </div>
                <div class="accordion-body">
                    {{ __('Orders ship within 1-2 business days. Free standard shipping on orders over :amount. Returns accepted within 30 days of delivery for unopened products.', ['amount' => $currencySymbol . '100']) }}
                </div>
            </div>

        </div>

        {{-- Reviews --}}
        <div class="reviews-section" id="reviews">
            <div class="accordion-title" style="margin-bottom:14px;">
                {{ __('Customer Reviews') }} ({{ $reviewsCount }})
            </div>

            @forelse($product->reviews as $review)
                <div class="review-item">
                    <div class="review-head">
                        <span class="review-author">{{ $review->user->name ?? __('Anonymous') }}</span>
                        <span class="review-date">{{ $review->created_at->format('d M Y') }}</span>
                    </div>
                    <span class="review-stars" aria-label="{{ $review->rating }} {{ __('out of 5 stars') }}" role="img">
                        @for($i = 1; $i <= 5; $i++)
                            <span class="{{ $i <= $review->rating ? 'star' : 'star dim' }}" aria-hidden="true">★</span>
                        @endfor
                    </span>
                    <div class="review-comment">{{ $review->comment }}</div>

                    @can('delete', $review)
                        <div class="review-actions">
                            <form method="POST" action="{{ route('review.destroy', $review) }}"
                                onsubmit="return confirm('{{ __('Delete this Review?') }}')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn del" title="{{ __('Delete') }}">
                                    <svg viewBox="0 0 24 24">
                                        <polyline points="3 6 5 6 21 6" />
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                        <path d="M10 11v6" />
                                        <path d="M14 11v6" />
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    @endcan
                </div>
            @empty
                <div class="no-reviews">{{ __('No reviews yet. Be the first to review this product.') }}</div>
            @endforelse

            {{-- Write a review --}}
            <div class="review-form-wrap">
                @auth
                    <div class="review-form-title">{{ __('Write a Review') }}</div>
                    <form method="POST" action="{{ route('store.review', $product->id) }}">
                        @csrf

                        <label class="review-form-label" for="reviewRating">{{ __('Your Rating') }}</label>
                        <select name="rating" id="reviewRating" class="review-form-select">
                            @foreach([5, 4, 3, 2, 1] as $r)
                                <option value="{{ $r }}">
                                    {{ $r }} {{ $r === 1 ? __('star') : __('stars') }}
                                </option>
                            @endforeach
                        </select>

                        <label class="review-form-label" for="reviewComment">{{ __('Your Review') }}</label>
                        <textarea name="comment" id="reviewComment" class="review-form-textarea"
                            placeholder="{{ __('Share your experience with this product…') }}" required></textarea>

                        <button type="submit" class="review-form-submit">
                            {{ __('Submit Review') }}
                        </button>
                    </form>
                @endauth

                @guest
                    <p class="review-login-note">
                        <a href="{{ route('login') }}">{{ __('Log in') }}</a>
                        {{ __('to write a review.') }}
                    </p>
                @endguest
            </div>

        </div>{{-- /reviews-section --}}

    </div>{{-- /product-info --}}
    </div>{{-- /product-main --}}

    {{-- ══ RELATED PRODUCTS ══ --}}
    @if($relatedProducts && $relatedProducts->count())
        <div class="related-section">
            <div class="related-header">
                <div class="related-title">{{ __('You May Also Like') }}</div>
                <div class="related-rule"></div>
            </div>
            <div class="related-grid">
                @foreach($relatedProducts as $related)
                    @php
                        $relatedName = $related->getTranslation('name', $locale);
                        $relatedHasSale = !is_null($related->sale_price);
                        $relatedPrice = $relatedHasSale ? $related->sale_price : $related->price;
                    @endphp
                    <a href="{{ route('store.products.show', $related->slug) }}" class="product-card">
                        <div class="product-img">
                            @if($related->images)
                                <img src="{{ asset('storage/' . $related->images) }}" alt="{{ $relatedName }}">
                            @endif
                        </div>
                        <div class="product-body">
                            @if($related->category)
                                <div class="product-cat">{{ $related->category->getTranslation('name', $locale) }}</div>
                            @endif
                            <div class="product-name">{{ $relatedName }}</div>
                            <div>
                                <span class="product-price">{{ $currencySymbol }}{{ number_format($relatedPrice, 2) }}</span>
                                @if($relatedHasSale)
                                    <span class="product-price-old">{{ $currencySymbol }}{{ number_format($related->price, 2) }}</span>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    @endif

@endsection

@push('scripts')
    <script>
        // Quantity control
        function changeQty(delta) {
            const input = document.getElementById('qty');
            const newVal = parseInt(input.value) + delta;
            const min = parseInt(input.min) || 1;
            const max = parseInt(input.max) || 9999;
            if (newVal >= min && newVal <= max) input.value = newVal;
        }

        // Size selector
        document.querySelectorAll('.size-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.size-btn').forEach(b => {
                    b.classList.remove('active');
                    b.setAttribute('aria-pressed', 'false');
                });
                this.classList.add('active');
                this.setAttribute('aria-pressed', 'true');
                document.getElementById('selectedSizeLabel').textContent = this.dataset.label;
                document.getElementById('selectedSizeId').value = this.dataset.sizeId;
            });
        });

        // Keyboard support for accordion
        document.querySelectorAll('.accordion-head').forEach(head => {
            head.addEventListener('keydown', function (e) {
                if (e.key === 'Enter' || e.key === ' ') {
                    e.preventDefault();
                    this.parentElement.classList.toggle('open');
                }
            });
        });
    </script>
@endpush