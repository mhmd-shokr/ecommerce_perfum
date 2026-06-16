@extends('layouts.admin.app')

@section('title', __('Categories'))
@section('page-title', __('Catalog'))
@section('breadcrumb', __('Categories'))

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
            pointer-events: none;
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
            transition: border-color 0.2s;
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

        .cat-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .cat-thumb {
            width: 38px;
            height: 38px;
            border-radius: 8px;
            border: 1px solid var(--border);
            overflow: hidden;
            flex-shrink: 0;
            background: var(--bg-hover);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .cat-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .cat-thumb-placeholder {
            font-size: 18px;
        }

        .cat-title {
            font-size: 14px;
            color: var(--text-primary);
            margin-bottom: 2px;
        }

        .cat-slug {
            font-size: 11px;
            color: var(--text-muted);
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

        .badge-parent {
            background: rgba(200, 169, 106, 0.08);
            color: var(--gold-dim);
            border: 1px solid rgba(200, 169, 106, 0.18);
            font-size: 11px;
            padding: 2px 9px;
            border-radius: 20px;
            white-space: nowrap;
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

        .pagination {
            display: flex;
            gap: 4px;
        }

        .page-btn {
            width: 32px;
            height: 32px;
            border-radius: 7px;
            border: 1px solid var(--border);
            background: var(--bg-card);
            color: var(--text-secondary);
            font-size: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-family: Arial, sans-serif;
            transition: all 0.15s;
        }

        .page-btn.active {
            border-color: var(--gold);
            color: var(--gold);
            background: rgba(200, 169, 106, 0.08);
        }

        .page-btn:hover:not(.active) {
            border-color: var(--gold-dim);
            color: var(--gold-dim);
        }

        .page-btn svg {
            width: 14px;
            height: 14px;
            stroke: currentColor;
            fill: none;
            stroke-width: 2;
            stroke-linecap: round;
            stroke-linejoin: round;
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
            <div class="page-heading">Category <span>{{ __('Catalog') }}</span></div>
            <div class="page-sub">{{ __('Manage product categories') }}</div>
        </div>
        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            <svg viewBox="0 0 24 24" width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round">
                <line x1="12" y1="5" x2="12" y2="19" />
                <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            {{ __('Add Category') }}
        </a>
    </div>

    {{-- Stats --}}
    <div class="stats-row">
        <div class="stat-card">
            <div class="stat-label">{{ __('Total Categories') }}</div>
            <div class="stat-val">{{ $categories->count()}}<span class="stat-note">{{ __('total') }}</span></div>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Active') }}</div>
            <div class="stat-val">{{ $categories->where('status', 1)->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Parent Categories') }}</div>
            <div class="stat-val">{{ $categories->whereNull('parent_id')->count() }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-label">{{ __('Sub-categories') }}</div>
            <div class="stat-val">{{ $categories->whereNotNull('parent_id')->count() }}</div>
        </div>
    </div>

    {{-- Toolbar --}}
    <div class="toolbar">
        <form method="GET" action="{{ route('admin.categories.index') }}" style="display:contents;">

            <div class="search-box">
                <svg viewBox="0 0 24 24">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
                <input class="search-input" type="text" name="search" value="{{ request('search') }}"
                    placeholder="{{ __('Search categories...') }}" autocomplete="off">
            </div>

            <div class="filter-links">
                <a href="{{ route('admin.categories.index', array_merge(request()->except('status', 'page'), [])) }}"
                    class="filter-link {{ !request('status') ? 'active' : '' }}">
                    {{ __('All') }}
                </a>
                <a href="{{ route('admin.categories.index', array_merge(request()->except('status', 'page'), ['status' => 'active'])) }}"
                    class="filter-link {{ request('status') === 'active' ? 'active' : '' }}">
                    {{ __('Active') }}
                </a>
                <a href="{{ route('admin.categories.index', array_merge(request()->except('status', 'page'), ['status' => 'inactive'])) }}"
                    class="filter-link {{ request('status') === 'inactive' ? 'active' : '' }}">
                    {{ __('Inactive') }}
                </a>
            </div>

            {{-- hidden inputs so search + status filters work together --}}
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif

        </form>
    </div>

    {{-- Table --}}
    <div class="table-wrap">
        @if($categories->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">📂</div>
                <div class="empty-title">{{ __('No categories found') }}</div>
                <div class="empty-sub">{{ __('Try adjusting your search or add a new category.') }}</div>
            </div>
        @else
            <table>
                <thead>
                    <tr>
                        <th>{{ __('Category') }}</th>
                        <th>{{ __('Parent') }}</th>
                        <th>{{ __('Slug') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Created') }}</th>
                        <th class="text-right">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($categories as $category)
                        <tr>
                            {{-- Name + thumbnail --}}
                            <td>
                                <div class="cat-cell">
                                    <div class="cat-thumb">
                                        @if($category->images)
                                            <img src="{{ asset('storage/' . $category->images) }}"
                                                alt="{{ $category->getTranslation('name', app()->getLocale()) }}">
                                        @else
                                            <span class="cat-thumb-placeholder">📁</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="cat-title">
                                            {{ $category->getTranslation('name', app()->getLocale()) }}
                                        </div>
                                        <div class="cat-slug">/{{ $category->slug }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- Parent --}}
                            <td>
                                @if($category->parent)
                                    <span class="badge-parent">
                                        {{ $category->parent->getTranslation('name', app()->getLocale()) }}
                                    </span>
                                @else
                                    <span style="color:var(--text-muted);">—</span>
                                @endif
                            </td>

                            {{-- Slug --}}
                            <td style="color:var(--text-muted); font-size:12px;">{{ $category->slug }}</td>

                            {{-- Status — assumes you add a status/is_active column later; defaults active for now --}}
                            <td>
                                @if($category->status == 1)
                                    <span class="badge badge-active"><span class="badge-dot"></span>{{ __('Active') }}</span>
                                @else
                                    <span class="badge badge-inactive"><span class="badge-dot"></span>{{ __('Inactive') }}</span>
                                @endif
                            </td>

                            {{-- Created --}}
                            <td>{{ $category->created_at->format('d M Y') }}</td>

                            {{-- Actions --}}
                            <td>
                                <div class="action-group">

                                    {{-- View / show
                                    <a href="{{ route('admin.categories.show', $category) }}" class="action-btn"
                                        title="{{ __('View') }}">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                                            <circle cx="12" cy="12" r="3" />
                                        </svg>
                                    </a> --}}

                                    {{-- Edit --}}
                                    <a href="{{ route('admin.categories.edit', $category) }}" class="action-btn"
                                        title="{{ __('Edit') }}">
                                        <svg viewBox="0 0 24 24">
                                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                                        </svg>
                                    </a>

                                    {{-- Delete --}}
                                    <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                                        onsubmit="return confirm('{{ __('Delete this category?') }}')">
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
    @if($categories->hasPages())
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
                <span style="color:var(--text-secondary);">{{ $categories->firstItem() }}</span>
                {{ __('to') }}
                <span style="color:var(--text-secondary);">{{ $categories->lastItem() }}</span>
                {{ __('of') }}
                <span style="color:var(--gold);">{{ $categories->total() }}</span>
                {{ __('results') }}
            </div>

            {{-- Pages --}}
            <div style="display:flex; align-items:center; gap:4px;">

                {{-- Prev --}}
                @if($categories->onFirstPage())
                    <span
                        style="width:32px;height:32px;border-radius:6px;border:1px solid var(--border);background:none;display:inline-flex;align-items:center;justify-content:center;opacity:0.3;cursor:not-allowed;">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="15 18 9 12 15 6" />
                        </svg>
                    </span>
                @else
                    <a href="{{ $categories->previousPageUrl() }}"
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
                @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                    @if($page == $categories->currentPage())
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
                @if($categories->hasMorePages())
                    <a href="{{ $categories->nextPageUrl() }}"
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