<style>
    .c-nav {
        background: rgba(10, 10, 10, 0.95);
        border-bottom: 1px solid var(--border);
        backdrop-filter: blur(12px);
        position: sticky;
        top: 0;
        z-index: 100;
    }

    .c-nav-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 32px;
        height: 70px;
        display: flex;
        align-items: center;
        gap: 40px;
    }

    .c-brand {
        display: flex;
        align-items: center;
        gap: 10px;
        text-decoration: none;
        flex-shrink: 0;
    }

    .c-brand-icon {
        width: 32px;
        height: 32px;
        border: 1.5px solid var(--gold);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .c-brand-icon svg {
        width: 16px;
        height: 16px;
        fill: var(--gold);
    }

    .c-brand-name {
        font-size: 16px;
        letter-spacing: 3px;
        color: var(--gold);
        text-transform: uppercase;
    }

    .c-nav-links {
        display: flex;
        align-items: center;
        gap: 4px;
        flex: 1;
    }

    .c-nav-link {
        padding: 6px 14px;
        color: var(--text-secondary);
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-size: 12px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        border-radius: 4px;
        transition: color 0.2s;
    }

    .c-nav-link:hover {
        color: var(--text-primary);
    }

    .c-nav-link.active {
        color: var(--gold);
    }

    .c-nav-right {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-left: auto;
    }

    [dir="rtl"] .c-nav-right {
        margin-left: 0;
        margin-right: auto;
    }

    .c-lang {
        display: flex;
        gap: 2px;
        background: rgba(255, 255, 255, 0.04);
        border: 1px solid var(--border);
        border-radius: 5px;
        padding: 2px;
    }

    .c-lang a {
        padding: 3px 9px;
        border-radius: 3px;
        font-size: 10px;
        letter-spacing: 1px;
        color: var(--text-muted);
        text-decoration: none;
        font-family: Arial, sans-serif;
        transition: all 0.15s;
    }

    .c-lang a.active {
        background: rgba(200, 169, 106, 0.15);
        color: var(--gold);
    }

    .c-icon-btn {
        width: 36px;
        height: 36px;
        border: 1px solid var(--border);
        border-radius: 6px;
        background: transparent;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-secondary);
        text-decoration: none;
        cursor: pointer;
        position: relative;
        transition: all 0.2s;
    }

    .c-icon-btn:hover {
        border-color: var(--gold-dim);
        color: var(--gold);
    }

    .c-icon-btn svg {
        width: 16px;
        height: 16px;
        stroke: currentColor;
        fill: none;
    }

    .c-cart-count {
        position: absolute;
        top: -5px;
        right: -5px;
        width: 16px;
        height: 16px;
        background: var(--gold);
        color: #0a0a0a;
        font-size: 9px;
        font-weight: 700;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Arial, sans-serif;
    }

    .c-btn-outline {
        padding: 7px 18px;
        border: 1px solid var(--border-strong);
        border-radius: 5px;
        color: var(--gold);
        font-family: Arial, sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        transition: all 0.2s;
        background: transparent;
        cursor: pointer;
    }

    .c-btn-outline:hover {
        background: rgba(200, 169, 106, 0.08);
        border-color: var(--gold);
    }

    .c-btn-gold {
        padding: 7px 18px;
        background: var(--gold);
        border: none;
        border-radius: 5px;
        color: #0a0a0a;
        font-family: Arial, sans-serif;
        font-size: 11px;
        letter-spacing: 1px;
        text-transform: uppercase;
        text-decoration: none;
        cursor: pointer;
        transition: background 0.2s;
        display: inline-block;
    }

    .c-btn-gold:hover {
        background: var(--gold-light);
    }
</style>

<nav class="c-nav">
    <div class="c-nav-inner">

        {{-- Brand --}}
        <a href="#" class="c-brand">
            <div class="c-brand-icon">
                <svg viewBox="0 0 24 24">
                    <path d="M12 2C12 2 8 6 8 10C8 14 10 16 12 18C14 16 16 14 16 10C16 6 12 2 12 2Z" />
                </svg>
            </div>
            <span class="c-brand-name">{{ config('app.name') }}</span>
        </a>

        {{-- Links --}}
        <div class="c-nav-links">
            <a href="{{ route('home') }}"
                class="c-nav-link {{ request()->is('/') ? 'active' : '' }}">{{ __('Home') }}</a>
            <a href="{{ route('shop.products') }}"
                class="c-nav-link {{ request()->is('products*') ? 'active' : '' }}">{{ __('Shop') }}</a>
            <a href="#"
                class="c-nav-link {{ request()->is('categories*') ? 'active' : '' }}">{{ __('Collections') }}</a>
            <a href="#" class="c-nav-link {{ request()->is('about*') ? 'active' : '' }}">{{ __('About') }}</a>
            <a href="{{ route("my.orders.index") }}" class="c-nav-link {{ request()->is('orders*') ? 'active' : '' }}">{{ __('Orders') }}</a>
        </div>

        {{-- Right side --}}
        <div class="c-nav-right">

            {{-- Language --}}
            <div class="c-lang">
                <a href="lang/en" class="{{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
                <a href="lang/ar" class="{{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
            </div>

            {{-- Search --}}
            <a href="#" class="c-icon-btn" title="{{ __('Search') }}">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </a>

            {{-- Wishlist --}}
            <a href="{{route('wishlist.index') }}"" class=" c-icon-btn" title="{{ __('Wishlist') }}">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path
                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" />
                </svg>
            </a>

            {{-- Cart --}}
            @php
                if (auth()->check()) {
                    $cartCount = auth()->user()->carts()->sum('quantity');
                } else {
                    $cart = session('cart', []);
                    $cartCount = array_sum(array_column($cart, 'quantity'));
                }

            @endphp
            <a href="{{ route("cart.index") }}" class="c-icon-btn" title="{{ __('Cart') }}">
                <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z" />
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <path d="M16 10a4 4 0 0 1-8 0" />
                </svg>
                {{-- <span class="c-cart-count">{{ auth()->check() ? auth()->user()->cartCount() : 0 }}</span> --}}
                <span class="c-cart-count">{{ $cartCount}}</span>
            </a>

            {{-- Auth --}}
            @auth
                <a href="{{ route('profile.update') }}" class="c-btn-outline">{{ auth()->user()->name }}</a>
                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button class="c-btn-gold">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}" class="c-btn-outline">{{ __('Login') }}</a>
                <a href="{{route('register')}}" class="c-btn-gold">{{ __('Register') }}</a>
            @endauth

        </div>
    </div>
</nav>