<style>
    .topbar {
        background: var(--bg-panel);
        border-bottom: 1px solid var(--border);
        padding: 0 32px;
        height: 60px;
        display: flex;
        align-items: center;
        gap: 16px;
        position: sticky; top: 0; z-index: 5;
    }
    .page-title { font-size: 13px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); font-family: Arial, sans-serif; }
    .topbar-sep { width: 1px; height: 16px; background: var(--border-strong); }
    .breadcrumb { font-size: 13px; color: var(--text-secondary); font-family: Arial, sans-serif; }
    .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 16px; }

    [dir="rtl"] .topbar-right { margin-left: 0; margin-right: auto; }

    .search-wrap { position: relative; display: flex; align-items: center; }
    .search-wrap svg { position: absolute; left: 10px; width: 14px; height: 14px; color: var(--text-muted); pointer-events: none; stroke: currentColor; }
    [dir="rtl"] .search-wrap svg { left: auto; right: 10px; }
    .search-input { background: var(--bg-card); border: 1px solid var(--border); border-radius: 6px; padding: 6px 12px 6px 32px; color: var(--text-primary); font-size: 12px; font-family: Arial, sans-serif; width: 200px; outline: none; transition: border-color 0.2s; }
    [dir="rtl"] .search-input { padding: 6px 32px 6px 12px; }
    .search-input::placeholder { color: var(--text-muted); }
    .search-input:focus { border-color: var(--gold-dim); }

    .lang-switch { display: flex; gap: 2px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 6px; padding: 2px; }
    .lang-btn { padding: 4px 10px; border: none; background: none; border-radius: 4px; font-size: 11px; letter-spacing: 1px; cursor: pointer; font-family: Arial, sans-serif; color: var(--text-secondary); text-decoration: none; transition: all 0.15s; display: inline-block; }
    .lang-btn.active { background: rgba(200,169,106,0.15); color: var(--gold); }

    .notif-btn { width: 32px; height: 32px; background: var(--bg-card); border: 1px solid var(--border); border-radius: 6px; display: flex; align-items: center; justify-content: center; cursor: pointer; position: relative; color: var(--text-secondary); transition: border-color 0.2s; }
    .notif-btn:hover { border-color: var(--gold-dim); color: var(--gold); }
    .notif-btn svg { width: 14px; height: 14px; stroke: currentColor; }
    .notif-dot { position: absolute; top: 5px; right: 5px; width: 6px; height: 6px; background: var(--gold); border-radius: 50%; border: 1.5px solid var(--bg-panel); }
</style>

<header class="topbar">
    <span class="page-title">@yield('page-title', __('Dashboard'))</span>
    <div class="topbar-sep"></div>
    <span class="breadcrumb">@yield('breadcrumb', __('Overview'))</span>

    <div class="topbar-right">

        {{-- Search --}}
        <div class="search-wrap">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input class="search-input" type="text" placeholder="{{ __('Search...') }}">
        </div>

        {{-- Language switcher --}}
        <div class="lang-switch">
            <a href="{{ route("locale.switch",'en') }}" class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ route('locale.switch','ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
        </div>

        {{-- Notifications --}}
        <div class="notif-btn" title="{{ __('Notifications') }}">
            <svg viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
            <span class="notif-dot"></span>
        </div>

    </div>
</header>
