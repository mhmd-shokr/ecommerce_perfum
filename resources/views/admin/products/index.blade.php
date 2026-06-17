@extends('layouts.admin.app')

@section('title', __('Products'))
@section('page-title', __('Catalog'))
@section('breadcrumb', __('Products'))

@push('styles')
    <style>
        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
        }

        .page-heading {
            font-size: 22px;
            color: var(--text-primary);
            font-weight: 400;
            letter-spacing: 1px;
            font-family: Georgia, serif;
        }

        .page-heading span {
            color: var(--gold);
        }

        .page-sub {
            font-size: 12px;
            color: var(--text-muted);
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-top: 4px;
            font-family: Arial, sans-serif;
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #C8A96A, #a8893a);
            border: none;
            border-radius: 8px;
            padding: 10px 20px;
            font-size: 12px;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: #0d0d0d;
            font-weight: 700;
            font-family: Arial, sans-serif;
            cursor: pointer;
            text-decoration: none;
            transition: opacity 0.2s;
        }

        .btn-primary:hover {
            opacity: 0.85;
            color: #0d0d0d;
        }

        .stats-row {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 16px 18px;
        }

        .stat-label {
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-bottom: 8px;
            font-family: Arial, sans-serif;
        }

        .stat-val {
            font-size: 26px;
            color: var(--text-primary);
            font-weight: 400;
        }

        .stat-note {
            font-size: 12px;
            color: var(--gold-dim);
            margin-left: 6px;
            font-family: Arial, sans-serif;
        }

        .toolbar {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            max-width: 300px;
        }

        .search-box svg {
            position: absolute;
            left: 11px;
            top: 50%;
            transform: translateY(-50%);
            width: 14px;
            height: 14px;
            color: var(--text-muted);
            stroke: currentColor;
        }

        .search-input {
            width: 100%;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 9px 12px 9px 34px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: Arial, sans-serif;
            outline: none;
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-input:focus {
            border-color: var(--gold-dim);
        }

        .filter-links {
            display: flex;
            gap: 4px;
        }

        .filter-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 14px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--bg-card);
            font-size: 12px;
            color: var(--text-secondary);
            font-family: Arial, sans-serif;
            text-decoration: none;
            transition: all 0.15s;
        }

        .filter-link:hover {
            border-color: var(--gold-dim);
            color: var(--gold-dim);
        }

        .filter-link.active {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200, 169, 106, 0.07);
        }

        .ml-auto {
            margin-left: auto;
        }

        .table-wrap {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 12px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead tr {
            border-bottom: 1px solid var(--border-strong);
        }

        th {
            padding: 13px 18px;
            text-align: left;
            font-size: 10px;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--text-muted);
            font-weight: 400;
            font-family: Arial, sans-serif;
            white-space: nowrap;
        }

        th.text-right {
            text-align: right;
        }

        tbody tr {
            border-bottom: 1px solid var(--border);
            transition: background 0.15s;
        }

        tbody tr:last-child {
            border-bottom: none;
        }

        tbody tr:hover {
            background: var(--bg-hover);
        }

        td {
            padding: 14px 18px;
            font-size: 13px;
            color: var(--text-secondary);
            vertical-align: middle;
            font-family: Arial, sans-serif;
        }

        .prod-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .prod-thumb {
            width: 42px;
            height: 42px;
            border-radius: 8px;
            border: 1px solid var(--border);
            overflow: hidden;
            flex-shrink: 0;
            background: var(--bg-hover);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .prod-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .prod-title {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 2px;
            font-family: Georgia, serif;
        }

        .prod-sku {
            font-size: 11px;
            color: var(--text-muted);
        }

        .price-cell .old-price {
            text-decoration: line-through;
            color: var(--text-muted);
            font-size: 11px;
            margin-right: 6px;
        }

        .price-cell .now-price {
            color: var(--gold);
            font-size: 13px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
        }

        .badge-active {
            background: rgba(122, 184, 122, 0.12);
            color: var(--success);
            border: 1px solid rgba(122, 184, 122, 0.25);
        }

        .badge-inactive {
            background: rgba(196, 80, 64, 0.10);
            color: var(--danger);
            border: 1px solid rgba(196, 80, 64, 0.20);
        }

        .badge-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: currentColor;
            display: inline-block;
        }

        .badge-cat {
            background: rgba(200, 169, 106, 0.08);
            color: var(--gold-dim);
            border: 1px solid rgba(200, 169, 106, 0.18);
            font-size: 11px;
            padding: 2px 9px;
            border-radius: 20px;
            white-space: nowrap;
        }

        .stock-pill {
            font-size: 12px;
        }

        .stock-low {
            color: var(--danger);
        }

        .stock-ok {
            color: var(--text-primary);
        }

        .tag-row {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .tag-feat {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 10px;
            background: rgba(200, 169, 106, 0.1);
            color: var(--gold);
            border: 1px solid rgba(200, 169, 106, 0.2);
        }

        .tag-best {
            font-size: 10px;
            padding: 2px 7px;
            border-radius: 10px;
            background: rgba(122, 184, 122, 0.1);
            color: var(--success);
            border: 1px solid rgba(122, 184, 122, 0.2);
        }

        .action-group {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 6px;
        }

        .action-btn {
            width: 30px;
            height: 30px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.15s;
            text-decoration: none;
        }

        .action-btn:hover {
            border-color: var(--gold-dim);
            color: var(--gold);
            background: rgba(200, 169, 106, 0.06);
        }

        .action-btn.del:hover {
            border-color: var(--danger);
            color: var(--danger);
            background: rgba(196, 80, 64, 0.07);
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

        .empty-state {
            text-align: center;
            padding: 60px 20px;
        }

        .empty-icon {
            font-size: 40px;
            margin-bottom: 14px;
            opacity: 0.3;
        }

        .empty-title {
            font-size: 16px;
            color: var(--text-primary);
            margin-bottom: 6px;
        }

        .empty-sub {
            font-size: 13px;
            color: var(--text-muted);
        }

        .footer-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 20px;
            flex-wrap: wrap;
            gap: 12px;
        }

        .page-info {
            font-size: 12px;
            color: var(--text-muted);
            font-family: Arial, sans-serif;
        }

        @media (max-width: 900px) {
            .stats-row {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .stats-row {
                grid-template-columns: 1fr;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-box {
                max-width: 100%;
            }

            .ml-auto {
                margin-left: 0;
            }
        }
    </style>
@endpush

@section('content')

    {{-- Page header --}}
    <div class="page-header">
        <div>
            <div class="page-heading">Product <span>Catalog</span></div>
            <div class="page-sub">{{ __('Manage your store products') }}</div>
        </div>
        <a href="{{ route('admin.products.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            {{ __('Add Product') }}
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">{{ __('Total Products') }}</div>
            <div class="stat-val">{{ $products->total() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Active') }}</div>
            <div class="stat-val">{{ $products->where('status', true)->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Out of Stock') }}</div>
            <div class="stat-val">{{ $products->where('is_out_of_stock', true)->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Featured') }}</div>
            <div class="stat-val">{{ $products->where('is_featured', true)->count() }}</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.products.index') }}" style="display:contents;">
            <div class="search-box">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input class="search-input" type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search products...') }}" autocomplete="off">
            </div>
            <div class="filter-links">
                <a href="{{ route('admin.products.index') }}"
                    class="filter-link {{ !request('status') ? 'active' : '' }}">{{ __('All') }}</a>
                <a href="{{ route('admin.products.index', ['status' => 'active']) }}"
                    class="filter-link {{ request('status') === 'active' ? 'active' : '' }}">{{ __('Active') }}</a>
                <a href="{{ route('admin.products.index', ['status' => 'inactive']) }}"
                    class="filter-link {{ request('status') === 'inactive' ? 'active' : '' }}">{{ __('Inactive') }}</a>
            </div>
        </form>
    </div>

    {{-- Table --}}
    <div class="table-wrap">
        @if($products->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📦</div>
                <div class="empty-title">{{ __('No products found') }}</div>
                <div class="empty-sub">{{ __('Try adjusting your search or add a new product.') }}</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Product') }}</th>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Brand') }}</th>
                        <th>{{ __('Price') }}</th>
                        <th>{{ __('Stock') }}</th>
                        <th>{{ __('Tags') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="prod-cell">
                                    <div class="prod-thumb">
                                        @if($product->images)
                                            <img src="{{ asset('storage/' . $product->images) }}"
                                                alt="{{ $product->getTranslation('name', app()->getLocale()) }}">
                                        @else
                                            <span style="font-size:18px;">🧴</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="prod-title">{{ $product->getTranslation('name', app()->getLocale()) }}</div>
                                        <div class="prod-sku">{{ $product->sku }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($product->category)
                                    <span class="badge-cat">{{ $product->category->getTranslation('name', app()->getLocale()) }}</span>
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>
                            <td>{{ $product->brand?->getTranslation('name', app()->getLocale()) ?? '—' }}</td>
                            <td class="price-cell">
                                @if($product->sale_price)
                                    <span class="old-price">{{ number_format($product->price, 2) }}</span>
                                    <span class="now-price">{{ number_format($product->sale_price, 2) }}</span>
                                @else
                                    <span class="now-price">{{ number_format($product->price, 2) }}</span>
                                @endif
                            </td>
                            <td>
                                @if($product->is_out_of_stock)
                                    <span class="stock-pill stock-low">{{ __('Out of stock') }}</span>
                                @else
                                    <span
                                        class="stock-pill {{ $product->stock_quantity <= $product->low_stock_threshold ? 'stock-low' : 'stock-ok' }}">
                                        {{ $product->stock_quantity }} {{ __('units') }}
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="tag-row">
                                    @if($product->is_featured)<span class="tag-feat">{{ __('Featured') }}</span>@endif
                                    @if($product->is_bestseller)<span class="tag-best">{{ __('Bestseller') }}</span>@endif
                                </div>
                            </td>
                            <td>
                                @if($product->status)
                                    <span class="badge badge-active"><span class="badge-dot"></span>{{ __('Active') }}</span>
                                @else
                                    <span class="badge badge-inactive"><span class="badge-dot"></span>{{ __('Inactive') }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-group">
                                    <a href="{{ route('admin.products.edit', $product) }}" class="action-btn"
                                        title="{{ __('Edit') }}">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>
                                    <form method="POST" action="{{ route('admin.products.destroy', $product) }}"
                                        onsubmit="return confirm('{{ __('Delete this product?') }}')">
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
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    {{-- Footer: pagination --}}
    @if($products->hasPages())
        <div style="
                     display: flex;
                     align-items: center;
                     justify-content: space-between;
                     padding: 14px 18px;
                     border-top: 1px solid var(--border);
                     flex-wrap: wrap;
                     gap: 10px;
                 ">
            {{-- Info --}}
            <div style="font-size:12px; color:var(--text-muted); font-family:Arial,sans-serif;">
                {{ __('Showing') }}
                <span style="color:var(--text-secondary);">{{ $products->firstItem() }}</span>
                {{ __('to') }}
                <span style="color:var(--text-secondary);">{{ $products->lastItem() }}</span>
                {{ __('of') }}
                <span style="color:var(--gold);">{{ $products->total() }}</span>
                {{ __('results') }}
            </div>

            {{-- Pages --}}
            <div style="display:flex; align-items:center; gap:4px;">

                {{-- Prev --}}
                @if($products->onFirstPage())
                    <span
                        style="width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;display:inline-flex;align-items:center;justify-content:center;opacity:0.3;cursor:not-allowed;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $products->previousPageUrl() }}"
                        style="width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:var(--bg-card);color:var(--text-secondary);display:inline-flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.15s;"
                        onmouseover="this.style.borderColor='var(--gold-dim)';this.style.color='var(--gold)'"
                        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                    </a>
                @endif

                {{-- Page numbers --}}
                @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                    @if($page == $products->currentPage())
                        <span
                            style="min-width:32px;height:32px;padding:0 8px;border-radius:6px;border:1px solid var(--gold);background:rgba(200,169,106,0.10);color:var(--gold);font-size:12px;font-family:Arial,sans-serif;display:inline-flex;align-items:center;justify-content:center;font-weight:700;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                            style="min-width:32px;height:32px;padding:0 8px;border-radius:6px;border:1px solid var(--border);background:var(--bg-card);color:var(--text-secondary);font-size:12px;font-family:Arial,sans-serif;display:inline-flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.15s;"
                            onmouseover="this.style.borderColor='var(--gold-dim)';this.style.color='var(--gold)'"
                            onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach

                {{-- Next --}}
                @if($products->hasMorePages())
                    <a href="{{ $products->nextPageUrl() }}"
                        style="width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:var(--bg-card);color:var(--text-secondary);display:inline-flex;align-items:center;justify-content:center;text-decoration:none;transition:all 0.15s;"
                        onmouseover="this.style.borderColor='var(--gold-dim)';this.style.color='var(--gold)'"
                        onmouseout="this.style.borderColor='var(--border)';this.style.color='var(--text-secondary)'">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </a>
                @else
                    <span
                        style="width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;display:inline-flex;align-items:center;justify-content:center;opacity:0.3;cursor:not-allowed;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="9 18 15 12 9 6" />
                        </svg>
                    </span>
                @endif

            </div>
        </div>
    @endif


@endsection