<style>
    .sidebar {
        width: 240px;
        background: var(--bg-panel);
        border-right: 1px solid var(--border);
        display: flex;
        flex-direction: column;
        position: fixed;
        top: 0; bottom: 0; left: 0;
        z-index: 10;
        overflow-y: auto;
    }
    .brand { padding: 28px 24px 24px; border-bottom: 1px solid var(--border); }
    .brand-mark { display: flex; align-items: center; gap: 10px; margin-bottom: 4px; }
    .brand-icon {
        width: 28px; height: 28px;
        border: 1.5px solid var(--gold);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .brand-icon svg { width: 14px; height: 14px; fill: var(--gold); }
    .brand-name { font-size: 15px; letter-spacing: 3px; color: var(--gold); text-transform: uppercase; font-weight: 400; }
    .brand-sub { font-size: 10px; letter-spacing: 2px; color: var(--text-muted); text-transform: uppercase; font-family: Arial, sans-serif; margin-left: 38px; }

    .nav { flex: 1; padding: 20px 0; }
    .nav-section-label { font-size: 9px; letter-spacing: 2.5px; color: var(--text-muted); text-transform: uppercase; font-family: Arial, sans-serif; padding: 0 24px; margin: 20px 0 8px; }

    .nav-link {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 24px;
        color: var(--text-secondary);
        text-decoration: none;
        font-family: Arial, sans-serif;
        font-size: 13px;
        border-left: 2px solid transparent;
        transition: all 0.2s;
    }
    .nav-link:hover { color: var(--text-primary); background: var(--bg-hover); border-left-color: var(--gold-dim); }
    .nav-link.active { color: var(--gold); background: rgba(200,169,106,0.06); border-left-color: var(--gold); }
    .nav-link svg { width: 16px; height: 16px; flex-shrink: 0; opacity: 0.7; stroke: currentColor; }
    .nav-link.active svg { opacity: 1; }
    .nav-badge { margin-left: auto; background: var(--gold); color: #0d0d0d; font-size: 10px; font-weight: 700; padding: 1px 6px; border-radius: 10px; font-family: Arial, sans-serif; }

    [dir="rtl"] .nav-link { border-left: none; border-right: 2px solid transparent; }
    [dir="rtl"] .nav-link:hover { border-right-color: var(--gold-dim); }
    [dir="rtl"] .nav-link.active { border-right-color: var(--gold); }
    [dir="rtl"] .nav-badge { margin-left: 0; margin-right: auto; }

    .sidebar-footer { padding: 16px 24px; border-top: 1px solid var(--border); }
    .user-chip { display: flex; align-items: center; gap: 10px; padding: 8px 10px; border-radius: 8px; background: var(--bg-hover); border: 1px solid var(--border); }
    .avatar { width: 28px; height: 28px; border-radius: 50%; background: linear-gradient(135deg, var(--gold-dim), var(--gold)); display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 700; color: #0d0d0d; font-family: Arial, sans-serif; flex-shrink: 0; }
    .user-info { flex: 1; min-width: 0; }
    .user-name { font-size: 12px; color: var(--text-primary); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; font-family: Arial, sans-serif; }
    .user-role { font-size: 10px; color: var(--gold-dim); letter-spacing: 1px; font-family: Arial, sans-serif; }
    .logout-btn { background: none; border: none; cursor: pointer; color: var(--text-muted); padding: 2px; }
    .logout-btn:hover { color: var(--danger); }
    .logout-btn svg { width: 14px; height: 14px; stroke: currentColor; }
</style>

<aside class="sidebar">
    {{-- Brand --}}
    <div class="brand">
        <div class="brand-mark">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C12 2 8 6 8 10C8 14 10 16 12 18C14 16 16 14 16 10C16 6 12 2 12 2Z"/></svg>
            </div>
            <span class="brand-name">{{ config('app.name') }}</span>
        </div>
        <div class="brand-sub">Admin Console</div>
    </div>

    {{-- Navigation --}}
    <nav class="nav">

        <div class="nav-section-label">{{ __('Overview') }}</div>

        <a class="nav-link {{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/></svg>
            {{ __('Dashboard') }}
        </a>

        <div class="nav-section-label">{{ __('Catalog') }}</div>

        <a class="nav-link {{ request()->is('admin/brands*') ? 'active' : '' }}" href="{{ route('admin.brands.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
            {{ __('Brands') }}
        </a>

        <a class="nav-link {{ request()->is('admin/categories*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18M3 12h18M3 18h18"/></svg>
            {{ __('Categories') }}
        </a>

        <a class="nav-link {{ request()->is('admin/products*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20 7H4C2.9 7 2 7.9 2 9v11c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V9c0-1.1-.9-2-2-2z"/><path d="M16 7V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2"/></svg>
            {{ __('Products') }}
        </a>

        <div class="nav-section-label">{{ __('Commerce') }}</div>

        <a class="nav-link {{ request()->is('admin/orders*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8h14M5 8a2 2 0 1 0 0-4h14a2 2 0 1 0 0 4M5 8l1 10c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2L19 8"/></svg>
            {{ __('Orders') }}
            <span class="nav-badge">{{ $pendingOrdersCount ?? 0 }}</span>
        </a>

        <a class="nav-link {{ request()->is('admin/coupons*') ? 'active' : '' }}" href="{{ route('admin.coupons.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 12l-8 8-8-8V4h8l8 8z"/>
                <circle cx="9" cy="9" r="1"/>
            </svg>            {{ __('Coupons') }}
        </a>

        <a class="nav-link {{ request()->is('admin/offers*') ? 'active' : '' }}" href="{{ route('admin.offers.index') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M20 12l-8 8-8-8V4h8l8 8z"/>
                <circle cx="9" cy="9" r="1"/>
            </svg>            {{ __('Offers') }}
        </a>

        <a class="nav-link {{ request()->is('admin/users*') ? 'active' : '' }}" href="#">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            {{ __('Customers') }}
        </a>

        <div class="nav-section-label">{{ __('System') }}</div>

        <a class="nav-link {{ request()->is('admin/settings*') ? 'active' : '' }}" href="#">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M12 1v4M12 19v4M4.22 4.22l2.83 2.83M16.95 16.95l2.83 2.83M1 12h4M19 12h4M4.22 19.78l2.83-2.83M16.95 7.05l2.83-2.83"/></svg>
            {{ __('Settings') }}
        </a>

    </nav>

    {{-- User + Logout --}}
    <div class="sidebar-footer">
        <div class="user-chip">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div class="user-info">
                <div class="user-name">{{ auth()->user()->name }}</div>
                <div class="user-role">{{ __('Admin') }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="logout-btn" title="{{ __('Logout') }}">
                    <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>