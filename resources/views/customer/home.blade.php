@extends('layouts.customer.app')

@section('title', __('Home'))

@section('content')
    <style>
        /* ── HERO ── */
        .hero {
            min-height: 88vh;
            display: flex;
            align-items: center;
            background: radial-gradient(ellipse at 60% 50%, rgba(200, 169, 106, 0.06) 0%, transparent 60%), #0a0a0a;
            border-bottom: 1px solid var(--border);
            padding: 80px 32px;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23C8A96A' fill-opacity='0.02'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .hero-inner {
            max-width: 1280px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 80px;
            align-items: center;
            position: relative;
        }

        .hero-eyebrow {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            margin-bottom: 20px;
        }

        .hero-title {
            font-size: clamp(36px, 5vw, 64px);
            color: var(--text-primary);
            font-weight: 400;
            line-height: 1.15;
            margin-bottom: 20px;
        }

        .hero-title span {
            color: var(--gold);
        }

        .hero-gold-rule {
            width: 48px;
            height: 1px;
            background: var(--gold);
            margin: 24px 0;
            opacity: 0.6;
        }

        .hero-desc {
            font-size: 15px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            line-height: 1.8;
            max-width: 380px;
            margin-bottom: 36px;
        }

        .hero-actions {
            display: flex;
            gap: 14px;
            flex-wrap: wrap;
        }

        .btn-gold {
            padding: 14px 32px;
            background: var(--gold);
            border: none;
            border-radius: 5px;
            color: #0a0a0a;
            font-family: Arial, sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: background 0.2s;
            display: inline-block;
        }

        .btn-gold:hover {
            background: var(--gold-light);
        }

        .btn-outline {
            padding: 14px 32px;
            background: none;
            border: 1px solid var(--border-strong);
            border-radius: 5px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            font-size: 11px;
            letter-spacing: 2px;
            text-transform: uppercase;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.2s;
            display: inline-block;
        }

        .btn-outline:hover {
            border-color: var(--gold);
            color: var(--gold);
        }

        .hero-visual {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-bottle-wrap {
            width: 320px;
            height: 420px;
            border: 1px solid var(--border);
            border-radius: 16px;
            background: linear-gradient(135deg, rgba(200, 169, 106, 0.06), rgba(200, 169, 106, 0.02));
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .hero-bottle-glow {
            position: absolute;
            inset: -40px;
            background: radial-gradient(circle, rgba(200, 169, 106, 0.12) 0%, transparent 70%);
            border-radius: 50%;
        }

        .hero-bottle-icon {
            font-size: 100px;
            position: relative;
        }

        .hero-badge {
            position: absolute;
            bottom: -16px;
            right: -16px;
            background: var(--bg-card);
            border: 1px solid var(--border-strong);
            border-radius: 10px;
            padding: 12px 16px;
            font-family: Arial, sans-serif;
        }

        .hero-badge-num {
            font-size: 22px;
            color: var(--gold);
            font-weight: 400;
        }

        .hero-badge-label {
            font-size: 10px;
            color: var(--text-muted);
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        /* ── SECTION SHARED ── */
        .section {
            padding: 80px 32px;
        }

        .section-inner {
            max-width: 1280px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 48px;
        }

        .section-eyebrow {
            font-size: 10px;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: var(--gold-dim);
            font-family: Arial, sans-serif;
            margin-bottom: 12px;
        }

        .section-title {
            font-size: 32px;
            color: var(--text-primary);
            font-weight: 400;
            margin-bottom: 14px;
        }

        .section-rule {
            width: 36px;
            height: 1px;
            background: var(--gold);
            margin: 0 auto 14px;
            opacity: 0.5;
        }

        .section-desc {
            font-size: 13px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            max-width: 480px;
            margin: 0 auto;
            line-height: 1.8;
        }

        /* ── PRODUCTS GRID ── */
        .products-grid {
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
            height: 200px;
            background: linear-gradient(135deg, rgba(200, 169, 106, 0.08), rgba(200, 169, 106, 0.03));
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 56px;
            border-bottom: 1px solid var(--border);
            position: relative;
        }

        .product-new {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--gold);
            color: #0a0a0a;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: Arial, sans-serif;
        }

        .product-sale {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--danger);
            color: white;
            font-size: 9px;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            padding: 3px 8px;
            border-radius: 3px;
            font-family: Arial, sans-serif;
        }

        .product-body {
            padding: 16px;
        }

        .product-cat {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            margin-bottom: 6px;
        }

        .product-name {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 8px;
        }

        .product-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 12px;
        }

        .product-price {
            font-size: 16px;
            color: var(--gold);
            font-family: Arial, sans-serif;
        }

        .product-price-old {
            font-size: 11px;
            color: var(--text-muted);
            text-decoration: line-through;
            margin-left: 6px;
            font-family: Arial, sans-serif;
        }

        .product-add {
            width: 30px;
            height: 30px;
            background: rgba(200, 169, 106, 0.1);
            border: 1px solid var(--border-strong);
            border-radius: 5px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gold);
            transition: background 0.2s;
            cursor: pointer;
        }

        .product-add:hover {
            background: rgba(200, 169, 106, 0.2);
        }

        .product-add svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
        }

        /* ── CATEGORIES ── */
        .cats-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .cat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 32px 24px;
            text-align: center;
            text-decoration: none;
            display: block;
            transition: all 0.2s;
            position: relative;
            overflow: hidden;
        }

        .cat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 2px;
            background: var(--gold);
            opacity: 0;
            transition: opacity 0.2s;
        }

        .cat-card:hover {
            border-color: var(--border-strong);
            transform: translateY(-2px);
        }

        .cat-card:hover::before {
            opacity: 1;
        }

        .cat-icon {
            font-size: 36px;
            margin-bottom: 14px;
        }

        .cat-name {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 6px;
            letter-spacing: 1px;
        }

        .cat-count {
            font-size: 11px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
            letter-spacing: 1px;
        }

        /* ── CTA BANNER ── */
        .cta-section {
            padding: 80px 32px;
            background: linear-gradient(135deg, rgba(200, 169, 106, 0.06) 0%, transparent 50%);
            border-top: 1px solid var(--border);
            border-bottom: 1px solid var(--border);
            text-align: center;
        }

        .cta-title {
            font-size: 36px;
            color: var(--text-primary);
            margin-bottom: 12px;
        }

        .cta-desc {
            font-size: 14px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            margin-bottom: 32px;
            max-width: 440px;
            margin-left: auto;
            margin-right: auto;
            line-height: 1.7;
        }

        .cta-input-row {
            display: flex;
            gap: 8px;
            max-width: 420px;
            margin: 0 auto;
        }

        .cta-input {
            flex: 1;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 5px;
            padding: 12px 16px;
            color: var(--text-primary);
            font-family: Arial, sans-serif;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s;
        }

        .cta-input::placeholder {
            color: var(--text-muted);
        }

        .cta-input:focus {
            border-color: var(--gold-dim);
        }

        .cta-submit {
            padding: 12px 24px;
            background: var(--gold);
            border: none;
            border-radius: 5px;
            color: #0a0a0a;
            font-family: Arial, sans-serif;
            font-size: 11px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            cursor: pointer;
            transition: background 0.2s;
            white-space: nowrap;
        }

        .cta-submit:hover {
            background: var(--gold-light);
        }

        @media (max-width: 900px) {
            .hero-inner {
                grid-template-columns: 1fr;
            }

            .hero-visual {
                display: none;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .cats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }
    </style>

    {{-- ── HERO ── --}}
    <section class="hero">
        <div class="hero-inner">
            <div>
                <div class="hero-eyebrow">{{ __('New Collection 2025') }}</div>
                <h1 class="hero-title">{{ __('The Art of') }}<br><span>{{ __('Luxury') }}</span><br>{{ __('Fragrance') }}
                </h1>
                <div class="hero-gold-rule"></div>
                <p class="hero-desc">
                    {{ __('Discover our curated collection of rare and exquisite perfumes, crafted by the finest perfumers from around the world.') }}
                </p>
                <div class="hero-actions">
                    <a href="{{ route('shop.products') }}" class="btn-gold">{{ __('Shop Now') }}</a>
                    <a href="#" class="btn-outline">{{ __('Explore Collections') }}</a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="hero-bottle-wrap">
                    <div class="hero-bottle-glow"></div>
                    <div class="hero-bottle-icon">🧴</div>
                    <div class="hero-badge">
                        <div class="hero-badge-num">200+</div>
                        <div class="hero-badge-label">{{ __('Fragrances') }}</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── FEATURED PRODUCTS ── --}}
    <section class="section">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-eyebrow">{{ __('Handpicked For You') }}</div>
                <h2 class="section-title">{{ __('Featured Fragrances') }}</h2>
                <div class="section-rule"></div>
                <p class="section-desc">{{ __('Each bottle tells a story. Discover the scents that define a moment.') }}</p>
            </div>
            <div class="products-grid">
                @foreach ($products as $product )
                    @if ($product->is_featured)
                    <a href="{{route('store.products.show',$product->slug)}}" class="product-card">
                        <div class="product-img"><img src="{{ asset('storage/'.$product->images) }}" alt="">
                            @if($product->is_new) <span class="product-new">New</span> @endif
                            @if($product->sale) <span class="product-sale">Sale</span> @endif
                            @if($product->is_bestseller)
                                <span class="product-bestseller">Best Seller</span>
                            @endif
                        </div>
                        <div class="product-body">
                            <div class="product-cat">{{ $product->category->getTranslation('name', app()->getLocale()) }}</div>
                            <div class="product-name"> {{ $product->getTranslation('name', app()->getLocale()) }} </div>
                            <div class="product-footer">
                                <div><span class="product-price">{{ $product->price }}</span></div>
                                <div class="product-add"><svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round">
                                        <line x1="12" y1="5" x2="12" y2="19" />
                                        <line x1="5" y1="12" x2="19" y2="12" />
                                    </svg></div>
                            </div>
                        </div>
                    </a>
                    @endif
                @endforeach
                
            </div>
        </div>
    </section>

    {{-- ── CATEGORIES ── --}}
    <section class="section" style="background: rgba(200,169,106,0.02); border-top: 1px solid var(--border);">
        <div class="section-inner">
            <div class="section-header">
                <div class="section-eyebrow">{{ __('Browse By') }}</div>
                <h2 class="section-title">{{ __('Collections') }}</h2>
                <div class="section-rule"></div>
            </div>
            <div class="cats-grid">

                @foreach($categories as $cat)
                    <a href="#" class="cat-card">
                        @if ($cat->images)
                        <div class="cat-icon"> <img src="{{ asset('storage/' . $cat->images) }}" alt="{{ $cat->getTranslation('name', app()->getLocale()) }}"></div>
                        @else
                        <span style="font-size:18px;">🧴</span>
                        @endif
                        <div class="cat-name"> {{ $cat->getTranslation('name', app()->getLocale()) }}</div>
                        <div class="cat-count">{{ $cat->products_count }} {{ __('fragrances') }}</div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ── NEWSLETTER CTA ── --}}
    <section class="cta-section">
        <div class="section-eyebrow">{{ __('Stay In The Know') }}</div>
        <h2 class="cta-title">{{ __('Join Our World') }}</h2>
        <p class="cta-desc">
            {{ __('Subscribe to receive early access to new launches, exclusive offers, and fragrance stories.') }}</p>
        <div class="cta-input-row">
            <input class="cta-input" type="email" placeholder="{{ __('Your email address') }}">
            <button class="cta-submit">{{ __('Subscribe') }}</button>
        </div>
    </section>

@endsection