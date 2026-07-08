@extends('layouts.admin.app')
@section('title', __('Customers'))

@section('content')
    <div style="padding:32px;max-width:1000px;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ __('Customers') }}
            </h1>
        </div>

        @if(session('success'))
            <div style="padding:12px 18px;margin-bottom:20px;background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.25);border-left:3px solid #7ab87a;border-radius:8px;color:#f0e6d0;font-size:12px;font-family:Arial,sans-serif;">
                {{ session('success') }}
            </div>
        @endif

        {{-- Filters --}}
        <form method="GET" action="{{ route('admin.customers.index') }}"
            style="display:flex;gap:12px;margin-bottom:20px;">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ __('Search name or email...') }}"
                style="flex:1;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
            <select name="status"
                style="background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                <option value="" style="background:#121212;">{{ __('All Statuses') }}</option>
                <option value="active" @selected(request('status') === 'active') style="background:#121212;">{{ __('Active') }}</option>
                <option value="blocked" @selected(request('status') === 'blocked') style="background:#121212;">{{ __('Blocked') }}</option>
            </select>
            <button type="submit"
                style="padding:10px 20px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                {{ __('Filter') }}
            </button>
        </form>

        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid rgba(200,169,106,0.15);">
                        <th style="text-align:left;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">{{ __('Name') }}</th>
                        <th style="text-align:left;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">{{ __('Email') }}</th>
                        <th style="text-align:left;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">{{ __('Status') }}</th>
                        <th style="text-align:right;padding:14px 24px;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;font-weight:400;">{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                        <tr style="border-bottom:1px solid rgba(200,169,106,0.06);">
                            <td style="padding:14px 24px;font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;">{{ $customer->name }}</td>
                            <td style="padding:14px 24px;font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">{{ $customer->email }}</td>
                            <td style="padding:14px 24px;">
                                @if($customer->is_active)
                                    <span style="padding:3px 10px;border-radius:20px;font-size:10px;background:rgba(122,184,122,0.12);color:#7ab87a;font-family:Arial,sans-serif;">{{ __('Active') }}</span>
                                @else
                                    <span style="padding:3px 10px;border-radius:20px;font-size:10px;background:rgba(196,80,64,0.12);color:#c45040;font-family:Arial,sans-serif;">{{ __('Blocked') }}</span>
                                @endif
                            </td>
                            <td style="padding:14px 24px;text-align:right;">
                                <a href="{{ route('admin.customers.edit', $customer) }}"
                                    style="font-size:11px;color:#8a7248;font-family:Arial,sans-serif;text-decoration:none;margin-right:16px;">
                                    {{ __('Manage') }}
                                </a>
                                <form action="{{ route('admin.customers.toggle-status', $customer) }}" method="POST" style="display:inline;"
                                    onsubmit="return confirm('{{ $customer->is_active ? __('Block this customer?') : __('Unblock this customer?') }}');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit"
                                        style="background:none;border:none;padding:0;font-size:11px;font-family:Arial,sans-serif;cursor:pointer;color:{{ $customer->is_active ? '#c45040' : '#7ab87a' }};">
                                        {{ $customer->is_active ? __('Block') : __('Unblock') }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding:28px;text-align:center;color:#5a5040;font-size:13px;font-family:Arial,sans-serif;">
                                {{ __('No customers found.') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
            <div style="margin-top:20px;">
                {{ $customers->links() }}
            </div>
        @endif

    </div>
@endsection