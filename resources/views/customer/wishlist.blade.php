@extends('layouts.customer.app')

@section('title', __('My Wishlist'))

@push('styles')
<style>
    .wishlist-wrap { max-width: 1280px; margin: 0 auto; padding: 40px 24px 80px; }

    .page-header { display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 10px; flex-wrap: wrap; gap: 12px; }
    .page-heading { font-family: 'Georgia', serif; font-size: 26px; color: var(--text-primary); font-weight: 400; letter-spacing: 0.5px; }
    .page-heading span { color: var(--gold); }
    .gold-rule { width: 36px; height: 1px; background: var(--gold); opacity: 0.5; margin: 12px 0 8px; }
    .page-sub { font-size: 12px; color: var(--text-muted); letter-spacing: 1px; margin-bottom: 30px; font-family: Arial, sans-serif; }

    .count-pill { display: inline-flex; align-items: center; gap: 6px; padding: 7px 16px; border: 1px solid var(--border); border-radius: 20px; background: var(--bg-card); font-size: 12px; color: var(--gold-dim); font-family: Arial, sans-serif; white-space: nowrap; }
    .count-pill b { color: var(--gold); font-weight: 700; }

    .grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }

    .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 12px; overflow: hidden; transition: border-color .2s; position: relative; }
    .card:hover { border-color: var(--border-strong); }

    .card-img-wrap { position: relative; aspect-ratio: 1/1.1; background: #0f0f0f; overflow: hidden; display: block; }
    .card-img-wrap img { width: 100%; height: 100%; object-fit: cover; display: block; opacity: 0.92; transition: transform .3s; }
    .card:hover .card-img-wrap img { transform: scale(1.04); }

    .sale-badge { position: absolute; top: 10px; left: 10px; background: rgba(196,80,64,0.15); color: #e08a7a; border: 1px solid rgba(196,80,64,0.3); font-size: 10px; letter-spacing: 1px; text-transform: uppercase; padding: 3px 9px; border-radius: 20px; font-family: Arial, sans-serif; z-index: 2; }

    /* Heart / wishlist toggle button */
    .heart-form { position: absolute; top: 8px; right: 8px; z-index: 2; }
    .pc__btn-wl {
        width: 32px; height: 32px; border-radius: 50%;
        background: rgba(13,13,13,0.65);
        border: 1px solid var(--border);
        display: flex; align-items: center; justify-content: center;
        cursor: pointer; transition: all .2s; padding: 0;
    }
    .pc__btn-wl:hover { border-color: var(--danger); background: rgba(196,80,64,0.12); }
    .pc__btn-wl svg { width: 15px; height: 15px; stroke: var(--text-secondary); fill: none; transition: all .2s; pointer-events: none; }
    .pc__btn-wl.filled-heart svg { fill: var(--danger); stroke: var(--danger); }
    .pc__btn-wl.filled-heart:hover svg { fill: var(--text-muted); stroke: var(--text-muted); }

    .card-body { padding: 14px 16px 16px; }
    .brand-name { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--gold-dim); margin-bottom: 4px; font-family: Arial, sans-serif; }
    .prod-name { font-family: Georgia, serif; font-size: 15px; color: var(--text-primary); margin-bottom: 8px; line-height: 1.35; text-decoration: none; display: block; }
    .prod-name:hover { color: var(--gold); }

    .price-row { display: flex; align-items: baseline; gap: 8px; margin-bottom: 12px; }
    .price-now { font-size: 15px; color: var(--gold); font-weight: 700; font-family: Arial, sans-serif; }
    .price-old { font-size: 12px; color: var(--text-muted); text-decoration: line-through; font-family: Arial, sans-serif; }

    .stock-row { display: flex; align-items: center; gap: 6px; margin-bottom: 14px; font-size: 11px; font-family: Arial, sans-serif; }
    .stock-dot { width: 6px; height: 6px; border-radius: 50%; }
    .stock-dot.in { background: var(--success); }
    .stock-dot.out { background: var(--danger); }
    .stock-text.in { color: var(--success); }
    .stock-text.out { color: var(--danger); }

    .card-actions { display: flex; gap: 8px; }
    .btn-cart { flex: 1; display: flex; align-items: center; justify-content: center; gap: 6px; padding: 9px 0; border-radius: 7px; background: linear-gradient(135deg, #C8A96A, #a8893a); color: #0d0d0d; font-size: 11px; font-weight: 700; letter-spacing: 1px; text-transform: uppercase; border: none; cursor: pointer; transition: opacity .2s; font-family: Arial, sans-serif; }
    .btn-cart:hover { opacity: 0.88; }
    .btn-cart:disabled { background: var(--bg-hover); color: var(--text-muted); cursor: not-allowed; border: 1px solid var(--border); }
    .btn-remove { width: 38px; flex-shrink: 0; display: flex; align-items: center; justify-content: center; border-radius: 7px; border: 1px solid var(--border); background: none; color: var(--text-muted); cursor: pointer; transition: all .2s; padding: 0; }
    .btn-remove:hover { border-color: var(--danger); color: var(--danger); background: rgba(196,80,64,0.06); }
    .btn-remove svg { width: 14px; height: 14px; stroke: currentColor; fill: none; pointer-events: none; }

    .empty-state { text-align: center; padding: 90px 20px; border: 1px dashed var(--border); border-radius: 14px; }
    .empty-icon-wrap { width: 64px; height: 64px; border-radius: 50%; background: rgba(200,169,106,0.06); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; margin: 0 auto 18px; }
    .empty-icon-wrap svg { width: 26px; height: 26px; stroke: var(--gold-dim); fill: none; }
    .empty-title { font-family: 'Georgia', serif; font-size: 18px; color: var(--text-primary); margin-bottom: 8px; }
    .empty-sub { font-size: 13px; color: var(--text-muted); margin-bottom: 22px; font-family: Arial, sans-serif; }
    .empty-btn { display: inline-flex; align-items: center; gap: 8px; padding: 11px 26px; background: linear-gradient(135deg, #C8A96A, #a8893a); border: none; border-radius: 7px; color: #0d0d0d; font-size: 11px; font-weight: 700; letter-spacing: 1.5px; text-transform: uppercase; cursor: pointer; text-decoration: none; font-family: Arial, sans-serif; }

    @media (max-width: 1000px) { .grid { grid-template-columns: repeat(3, 1fr); } }
    @media (max-width: 760px) { .grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 480px) { .grid { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
<div class="wishlist-wrap">

    {{-- Flash messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Page header --}}
    <div class="page-header">
        <div>
            <div class="page-heading">My <span>{{ __('Wishlist') }}</span></div>
            <div class="gold-rule"></div>
            <div class="page-sub">{{ __("Items you've saved for later") }}</div>
        </div>

        @if($products->count())
            <span class="count-pill"><b>{{ $products->count() }}</b>&nbsp;{{ __('items saved') }}</span>
        @endif
    </div>

    @if($products->isEmpty())

        {{-- Empty state --}}
        <div class="empty-state">
            <div class="empty-icon-wrap">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z"/>
                </svg>
            </div>
            <div class="empty-title">{{ __('Your wishlist is empty') }}</div>
            <div class="empty-sub">{{ __('Save your favorite fragrances here to find them easily later.') }}</div>
            <a href="{{ route('shop.products') }}" class="empty-btn">{{ __('Browse Products') }}</a>
        </div>

    @else

        {{-- Product grid --}}
        <div class="grid">
            @php
                $wishlist = session('wishlist', []);
            @endphp

            @foreach($products as $product)
                @php
                    $inStock = !$product->is_out_of_stock && $product->stock_quantity > 0;
                @endphp

                <div class="card">
                    <a href="{{ route('store.products.show', $product->slug) }}" class="card-img-wrap">
                        @if($product->images)
                            <img src="{{ asset('storage/' . (is_array($product->images) ? $product->images[0] : $product->images)) }}"
                                alt="{{ $product->getTranslation('name', app()->getLocale()) }}">
                        @else
                            <img src="https://placehold.co/400x440/0f0f0f/5a5040?text=No+Image" alt="{{ $product->getTranslation('name', app()->getLocale()) }}">
                        @endif

                        @if($product->sale_price)
                            <span class="sale-badge">{{ __('Sale') }}</span>
                        @endif
                    </a>

                    {{-- Wishlist toggle --}}
                    <div class="heart-form">
                        <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                            @csrf
                            @if(in_array($product->id, $wishlist))
                                <button type="submit" class="pc__btn-wl filled-heart" title="{{ __('Remove From Wishlist') }}" aria-label="{{ __('Remove from wishlist') }}">
                                    <svg viewBox="0 0 20 20"><path d="M10 17.5s-6.5-4.2-8.5-8.2C-0.2 5.8 1.5 2.5 5 2.5c2 0 3.5 1.2 5 3 1.5-1.8 3-3 5-3 3.5 0 5.2 3.3 3.5 6.8-2 4-8.5 8.2-8.5 8.2z"/></svg>
                                </button>
                            @else
                                <button type="submit" class="pc__btn-wl" title="{{ __('Add To Wishlist') }}" aria-label="{{ __('Add to wishlist') }}">
                                    <svg viewBox="0 0 20 20"><path d="M10 17.5s-6.5-4.2-8.5-8.2C-0.2 5.8 1.5 2.5 5 2.5c2 0 3.5 1.2 5 3 1.5-1.8 3-3 5-3 3.5 0 5.2 3.3 3.5 6.8-2 4-8.5 8.2-8.5 8.2z"/></svg>
                                </button>
                            @endif
                        </form>
                    </div>

                    <div class="card-body">
                        <div class="brand-name">{{ $product->brand?->getTranslation('name', app()->getLocale()) }}</div>
                        <a href="{{ route('store.products.show', $product->slug) }}" class="prod-name">
                            {{ $product->getTranslation('name', app()->getLocale()) }}
                        </a>

                        <div class="price-row">
                            @if($product->sale_price)
                                <span class="price-old">{{ number_format($product->price, 0) }} {{ __('EGP') }}</span>
                                <span class="price-now">{{ number_format($product->sale_price, 0) }} {{ __('EGP') }}</span>
                            @else
                                <span class="price-now">{{ number_format($product->price, 0) }} {{ __('EGP') }}</span>
                            @endif
                        </div>

                        <div class="stock-row">
                            @if($inStock)
                                <span class="stock-dot in"></span>
                                <span class="stock-text in">{{ __('In stock') }}</span>
                            @else
                                <span class="stock-dot out"></span>
                                <span class="stock-text out">{{ __('Out of stock') }}</span>
                            @endif
                        </div>

                        <div class="card-actions">

                            {{-- Add to cart --}}
                            <form action="#" method="POST" style="flex:1;">
                                @csrf
                                <button type="submit" class="btn-cart" {{ !$inStock ? 'disabled' : '' }} style="width:100%;">
                                    {{ $inStock ? __('Add to cart') : __('Out of stock') }}
                                </button>
                            </form>

                            {{-- Remove from wishlist --}}
                            <form action="{{ route('wishlist.toggle', $product->id) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn-remove" title="{{ __('Remove') }}" aria-label="{{ __('Remove from wishlist') }}">
                                    <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                        <polyline points="3 6 5 6 21 6"/>
                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                                        <path d="M10 11v6"/><path d="M14 11v6"/>
                                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                                    </svg>
                                </button>
                            </form>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    @endif

</div>
@endsection