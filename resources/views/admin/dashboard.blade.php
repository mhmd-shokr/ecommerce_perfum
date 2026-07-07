@extends('layouts.admin.app')

@section('title', __('Dashboard'))
@section('page-title', __('Dashboard'))
@section('breadcrumb', __('Overview') . ' → ' . __('Analytics'))

@section('content')

<style>
    /* نفس التصميم بدون أي تعديل */
    .dash-header { margin-bottom: 28px; }
    .dash-title { font-size: 22px; color: var(--text-primary); font-weight: 400; letter-spacing: 0.5px; margin-bottom: 4px; }
    .dash-sub { font-size: 12px; color: var(--text-secondary); font-family: Arial, sans-serif; }
    .gold-rule { width: 36px; height: 1px; background: var(--gold); margin: 12px 0; }

    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }

    .stat-card {
        background: var(--bg-card); border: 1px solid var(--border);
        border-radius: 10px; padding: 20px; position: relative;
        overflow: hidden; cursor: pointer; transition: border-color 0.2s;
    }

    .stat-icon {
        width: 34px; height: 34px; background: rgba(200,169,106,0.08);
        border: 1px solid var(--border); border-radius: 8px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 14px; color: var(--gold);
    }

    .stat-label { font-size: 10px; letter-spacing: 2px; text-transform: uppercase; color: var(--text-muted); }
    .stat-value { font-size: 26px; color: var(--text-primary); margin-bottom: 8px; }
    .stat-delta { font-size: 11px; display: flex; gap: 4px; }

    .delta-warn { color: var(--gold); }
    .delta-label { color: var(--text-muted); }

    .main-grid { display: grid; grid-template-columns: 1fr 340px; gap: 20px; }

    .card { background: var(--bg-card); border: 1px solid var(--border); border-radius: 10px; }

    .card-header {
        padding: 18px 24px 14px;
        border-bottom: 1px solid var(--border);
        display: flex;
        justify-content: space-between;
    }

    .card-title { font-size: 13px; text-transform: uppercase; }

    table { width: 100%; border-collapse: collapse; }

    tbody tr { border-bottom: 1px solid rgba(200,169,106,0.06); cursor: pointer; }

    .product-cell { display: flex; gap: 12px; }

    .status-pill { padding: 3px 10px; border-radius: 20px; font-size: 10px; }

    .status-low { background: rgba(200,169,106,0.12); color: var(--gold); }

    .status-out { background: rgba(196,80,64,0.12); color: var(--danger); }

    .status-active { background: rgba(122,184,122,0.12); color: #7ab87a; }

    .order-row { display: flex; padding: 11px 20px; cursor: pointer; }

    .empty-state { padding: 28px; text-align: center; color: var(--text-muted); }
</style>

@php
    $pendingCollection = collect($data['pendingOrders'] ?? []);
    $lowStockCount     = $data['lowStockProducts'] ?? 0;
@endphp

{{-- HEADER --}}
<div class="dash-header">
    <div class="dash-title">
        {{ __('Good') }}
        {{ now()->hour < 12 ? __('morning') : (now()->hour < 18 ? __('afternoon') : __('evening')) }},
        {{ auth()->user()->name }}
    </div>

    <div class="gold-rule"></div>

    <div class="dash-sub">
        {{ __("Here is what is happening in your store today") }} — {{ now()->format('l, d F Y') }}
    </div>
</div>

{{-- LOW STOCK ALERT --}}
@if($lowStockCount > 0)
    <div class="empty-state">
        ⚠ {{ $lowStockCount }} {{ __('products are running low on stock') }}
    </div>
@endif

{{-- STATS --}}
<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-label">{{ __('Total Revenue') }}</div>
        <div class="stat-value">${{ number_format($data['totalRevenue'] ?? 0, 0) }}</div>
        <div class="stat-delta">
            <span class="delta-label">{{ __('completed orders') }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">{{ __('Total Orders') }}</div>
        <div class="stat-value">{{ number_format($data['ordersCount'] ?? 0) }}</div>
        <div class="stat-delta">
            <span class="delta-warn">{{ $pendingCollection->count() }}</span>
            <span class="delta-label">{{ __('pending') }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">{{ __('Customers') }}</div>
        <div class="stat-value">{{ number_format($data['usersCount'] ?? 0) }}</div>
        <div class="stat-delta">
            <span class="delta-label">{{ __('registered users') }}</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-label">{{ __('Products') }}</div>
        <div class="stat-value">{{ number_format($data['productsCount'] ?? 0) }}</div>
        <div class="stat-delta">
            <span class="delta-warn">{{ $lowStockCount }}</span>
            <span class="delta-label">{{ __('low stock') }}</span>
        </div>
    </div>

</div>

{{-- MAIN GRID --}}
<div class="main-grid">

    {{-- TOP SELLING --}}
    <div class="card">

        <div class="card-header">
            <span class="card-title">{{ __('Top Selling Products') }}</span>
        </div>

        <table>
            <tbody>
            @forelse($data['topSelling'] ?? [] as $product)
                <tr onclick="window.location='{{ route('admin.products.edit', $product->id) }}'">
                    <td>
                        <div class="product-cell">
                            <div>
                                {{ $product->getTranslation('name', app()->getLocale()) }}
                            </div>
                        </div>
                    </td>

                    <td>${{ number_format($product->price ?? 0, 2) }}</td>
                    <td>{{ $product->total_sold ?? 0 }}</td>
                    <td>{{ $product->stock_quantity }}</td>

                    <td>
                        @if($product->stock_quantity <= 0)
                            <span class="status-pill status-out">Out</span>
                        @elseif($product->stock_quantity <= 5)
                            <span class="status-pill status-low">Low</span>
                        @else
                            <span class="status-pill status-active">In</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td class="empty-state">No data</td>
                </tr>
            @endforelse
            </tbody>
        </table>

    </div>

    {{-- SIDE --}}
    <div>

        {{-- PENDING ORDERS --}}
        <div class="card">

            <div class="card-header">
                <span class="card-title">{{ __('Pending Orders') }}</span>
            </div>

            @forelse($pendingCollection as $order)
                <div class="order-row">
                    <div>#{{ $order->id }}</div>
                    <div style="flex:1">
                        {{ $order->user->name ?? 'Guest' }}
                    </div>
                    <div>${{ $order->total ?? 0 }}</div>
                </div>
            @empty
                <div class="empty-state">No pending orders</div>
            @endforelse

        </div>

    </div>

</div>

@endsection