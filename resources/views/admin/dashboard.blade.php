@extends('layouts.admin.app')

@section('title', __('Dashboard'))
@section('page-title', __('Dashboard'))
@section('breadcrumb', __('Overview') . ' → ' . __('Analytics'))

@section('content')
<style>
    .dash-header { margin-bottom: 28px; }
    .dash-title { font-size: 22px; color: var(--text-primary); font-weight: 400; letter-spacing: 0.5px; margin-bottom: 4px; }
    .dash-sub { font-size: 12px; color: var(--text-secondary); font-family: Arial, sans-serif; }
    .gold-rule { width: 36px; height: 1px; background: var(--gold); margin: 12px 0; }

    /* Stat cards */
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }

    .stat-card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; padding: 20px; position: relative; overflow: hidden; cursor: pointer; transition: border-color 0.2s; }
    .stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 2px; background: var(--gold); opacity: 0.3; transition: opacity 0.2s; }
    .stat-card:hover { border-color: var(--border-strong); }
    .stat-card:hover::before { opacity: 0.9; }

    .stat-icon { width: 34px; height: 34px; background: rgba(200,169,106,0.08); border: 1px solid var(--border); border-radius: 8px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; color: var(--gold); }
    .stat-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; }
    .stat-label { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); font-family: Arial, sans-serif; margin-bottom: 6px; }
    .stat-value { font-size: 26px; color: var(--text-primary); letter-spacing: -0.5px; line-height: 1; margin-bottom: 8px; }
    .stat-delta { font-size: 11px; font-family: Arial, sans-serif; display: flex; align-items: center; gap: 4px; }
    .delta-up { color: #7ab87a; }
    .delta-down { color: var(--danger); }
    .delta-label { color: var(--text-muted); }

    /* Grid */
    .main-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }

    /* Card */
    .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; overflow: hidden; }
    .card-header { padding: 18px 24px 14px; border-bottom: 1px solid var(--border); display: flex; align-items: center; justify-content: space-between; }
    .card-title { font-size: 13px; color: var(--text-primary); letter-spacing: 1.5px; text-transform: uppercase; font-family: Arial, sans-serif; display: flex; align-items: center; gap: 8px; }
    .card-title-dot { width: 4px; height: 4px; background: var(--gold); border-radius: 50%; }
    .card-action { font-size: 11px; color: var(--gold-dim); font-family: Arial, sans-serif; cursor: pointer; letter-spacing: 0.5px; padding: 4px 10px; border: 1px solid var(--border); border-radius: 4px; background: none; transition: all 0.15s; text-decoration: none; }
    .card-action:hover { color: var(--gold); border-color: var(--gold-dim); }

    /* Table */
    table { width: 100%; border-collapse: collapse; }
    thead th { padding: 10px 24px; font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); font-family: Arial, sans-serif; font-weight: 400; text-align: left; background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--border); }
    tbody tr { border-bottom: 1px solid rgba(200,169,106,0.06); cursor: pointer; transition: background 0.15s; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: var(--bg-hover); }
    tbody td { padding: 12px 24px; font-size: 12px; font-family: Arial, sans-serif; color: var(--text-secondary); vertical-align: middle; }

    .product-cell { display: flex; align-items: center; gap: 12px; }
    .product-thumb { width: 32px; height: 32px; border-radius: 6px; background: rgba(200,169,106,0.08); border: 1px solid var(--border); display: flex; align-items: center; justify-content: center; font-size: 14px; flex-shrink: 0; }
    .product-name { color: var(--text-primary); font-size: 13px; }
    .product-sku { font-size: 10px; color: var(--text-muted); letter-spacing: 1px; margin-top: 1px; }

    .status-pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: 10px; letter-spacing: 1px; text-transform: uppercase; font-family: Arial, sans-serif; }
    .status-active { background: rgba(122,184,122,0.12); color: #7ab87a; border: 1px solid rgba(122,184,122,0.25); }
    .status-low    { background: rgba(200,169,106,0.12); color: var(--gold); border: 1px solid var(--border-strong); }
    .status-out    { background: rgba(196,80,64,0.12);  color: var(--danger); border: 1px solid rgba(196,80,64,0.25); }

    /* Side cards */
    .side-stack { display: flex; flex-direction: column; gap: 20px; }
    .order-row { display: flex; align-items: center; gap: 10px; padding: 10px 20px; border-bottom: 1px solid rgba(200,169,106,0.06); cursor: pointer; transition: background 0.15s; }
    .order-row:last-child { border-bottom: none; }
    .order-row:hover { background: var(--bg-hover); }
    .order-id { font-size: 12px; color: var(--gold); font-family: 'Courier New', monospace; min-width: 60px; }
    .order-customer { flex: 1; font-size: 12px; color: var(--text-primary); font-family: Arial, sans-serif; }
    .order-amount { font-size: 12px; color: var(--text-secondary); font-family: Arial, sans-serif; }

    .activity-row { display: flex; gap: 12px; padding: 10px 20px; border-bottom: 1px solid rgba(200,169,106,0.06); }
    .activity-row:last-child { border-bottom: none; }
    .activity-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--gold); margin-top: 5px; flex-shrink: 0; }
    .activity-text { font-size: 12px; color: var(--text-secondary); font-family: Arial, sans-serif; line-height: 1.5; }
    .activity-time { font-size: 10px; color: var(--text-muted); margin-top: 2px; font-family: Arial, sans-serif; }
</style>

<div class="dash-header">
    <div class="dash-title">{{ __('Good') }} {{ now()->hour < 12 ? __('morning') : (now()->hour < 18 ? __('afternoon') : __('evening')) }}, {{ auth()->user()->name }}</div>
    <div class="gold-rule"></div>
    <div class="dash-sub">{{ __("Here is what is happening in your store today") }} — {{ now()->format('l, d F Y') }}</div>
</div>

{{-- Stat Cards --}}
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon"><svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg></div>
        <div class="stat-label">{{ __('Revenue Today') }}</div>
        {{-- <div class="stat-value">${{ number_format($revenueToday, 0) }}</div> --}}
        <div class="stat-value">$4,820</div>
        <div class="stat-delta"><span class="delta-up">↑ 12.4%</span><span class="delta-label">{{ __('vs yesterday') }}</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8h14M5 8a2 2 0 1 0 0-4h14a2 2 0 1 0 0 4M5 8l1 10c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2L19 8"/></svg></div>
        <div class="stat-label">{{ __('Orders') }}</div>
        {{-- <div class="stat-value">{{ $ordersToday }}</div> --}}
        <div class="stat-value">38</div>
        <div class="stat-delta"><span class="delta-up">↑ 5</span><span class="delta-label">{{ __('since yesterday') }}</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
        <div class="stat-label">{{ __('New Customers') }}</div>
        {{-- <div class="stat-value">{{ $newCustomers }}</div> --}}
        <div class="stat-value">14</div>
        <div class="stat-delta"><span class="delta-down">↓ 2</span><span class="delta-label">{{ __('vs last week') }}</span></div>
    </div>
    <div class="stat-card">
        <div class="stat-icon"><svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="22 12 18 12 15 21 9 3 6 12 2 12"/></svg></div>
        <div class="stat-label">{{ __('Conversion') }}</div>
        {{-- <div class="stat-value">{{ $conversionRate }}%</div> --}}
        <div class="stat-value">3.7%</div>
        <div class="stat-delta"><span class="delta-up">↑ 0.4%</span><span class="delta-label">{{ __('this month') }}</span></div>
    </div>
</div>

{{-- Main Grid --}}
<div class="main-grid">

    {{-- Products Table --}}
    <div class="card">
        <div class="card-header">
            <span class="card-title"><span class="card-title-dot"></span>{{ __('Top Products') }}</span>
            <a href="#" class="card-action">{{ __('View all') }} →</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>{{ __('Product') }}</th>
                    <th>{{ __('Price') }}</th>
                    <th>{{ __('Stock') }}</th>
                    <th>{{ __('Status') }}</th>
                </tr>
            </thead>
            <tbody>
                {{--
                @foreach($topProducts as $product)
                <tr>
                    <td>
                        <div class="product-cell">
                            <div class="product-thumb">🌹</div>
                            <div>
                                <div class="product-name">{{ $product->name }}</div>
                                <div class="product-sku">{{ $product->sku }}</div>
                            </div>
                        </div>
                    </td>
                    <td>${{ $product->price }}</td>
                    <td>{{ $product->stock }}</td>
                    <td>
                        @if($product->stock > 20)
                            <span class="status-pill status-active">{{ __('In Stock') }}</span>
                        @elseif($product->stock > 0)
                            <span class="status-pill status-low">{{ __('Low Stock') }}</span>
                        @else
                            <span class="status-pill status-out">{{ __('Out of Stock') }}</span>
                        @endif
                    </td>
                </tr>
                @endforeach
                --}}
                <tr>
                    <td><div class="product-cell"><div class="product-thumb">🌹</div><div><div class="product-name">Rose Noir Intense</div><div class="product-sku">SKU-00142</div></div></div></td>
                    <td>$189</td><td>84</td>
                    <td><span class="status-pill status-active">{{ __('In Stock') }}</span></td>
                </tr>
                <tr>
                    <td><div class="product-cell"><div class="product-thumb">🌿</div><div><div class="product-name">Oud Silk Élite</div><div class="product-sku">SKU-00098</div></div></div></td>
                    <td>$340</td><td>12</td>
                    <td><span class="status-pill status-low">{{ __('Low Stock') }}</span></td>
                </tr>
                <tr>
                    <td><div class="product-cell"><div class="product-thumb">🪵</div><div><div class="product-name">Amber & Cedar</div><div class="product-sku">SKU-00077</div></div></div></td>
                    <td>$220</td><td>0</td>
                    <td><span class="status-pill status-out">{{ __('Out of Stock') }}</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="side-stack">

        {{-- Recent Orders --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title"><span class="card-title-dot"></span>{{ __('Recent Orders') }}</span>
                <a href="#" class="card-action">{{ __('All orders') }} →</a>
            </div>
            {{--
            @foreach($recentOrders as $order)
            <div class="order-row">
                <span class="order-id">#{{ $order->id }}</span>
                <span class="order-customer">{{ $order->user->name }}</span>
                <span class="order-amount">${{ $order->total }}</span>
            </div>
            @endforeach
            --}}
            <div class="order-row"><span class="order-id">#4821</span><span class="order-customer">Layla Hassan</span><span class="order-amount">$340</span></div>
            <div class="order-row"><span class="order-id">#4820</span><span class="order-customer">Omar Khalil</span><span class="order-amount">$189</span></div>
            <div class="order-row"><span class="order-id">#4819</span><span class="order-customer">Sara Mansour</span><span class="order-amount">$95</span></div>
            <div class="order-row"><span class="order-id">#4818</span><span class="order-customer">Ahmed Al-Farsi</span><span class="order-amount">$440</span></div>
        </div>

        {{-- Activity --}}
        <div class="card">
            <div class="card-header">
                <span class="card-title"><span class="card-title-dot"></span>{{ __('Activity') }}</span>
            </div>
            <div class="activity-row"><div class="activity-dot"></div><div><div class="activity-text">{{ __('New order placed for Oud Silk Élite') }}</div><div class="activity-time">{{ __('2 min ago') }}</div></div></div>
            <div class="activity-row"><div class="activity-dot" style="background:var(--text-muted)"></div><div><div class="activity-text">{{ __('Amber & Cedar marked out of stock') }}</div><div class="activity-time">{{ __('18 min ago') }}</div></div></div>
            <div class="activity-row"><div class="activity-dot"></div><div><div class="activity-text">{{ __('New customer registered') }}</div><div class="activity-time">{{ __('1 hr ago') }}</div></div></div>
        </div>

    </div>
</div>
@endsection