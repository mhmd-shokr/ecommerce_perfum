@extends('layouts.admin.app')
@section('title', __('Coupons'))

@section('content')
<div style="padding:32px;">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
        <div>
            <h1 style="font-size:22px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;margin-bottom:4px;">
                {{ __('Coupons') }}
            </h1>
            <p style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;">
                {{ $coupons->total() }} {{ __('total coupons') }}
            </p>
        </div>
        <a href="{{ route('admin.coupons.create') }}"
           style="padding:10px 20px;background:#C8A96A;border-radius:7px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;text-decoration:none;">
            + {{ __('New Coupon') }}
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#7ab87a;font-family:Arial,sans-serif;margin-bottom:20px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">

        {{-- Header --}}
        <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr 1fr 1fr 120px;gap:16px;padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
            <span>{{ __('Code') }}</span>
            <span>{{ __('Type') }}</span>
            <span>{{ __('Value') }}</span>
            <span>{{ __('Usage') }}</span>
            <span>{{ __('Expires') }}</span>
            <span>{{ __('Status') }}</span>
            <span></span>
        </div>

        @forelse($coupons as $coupon)
            <div style="display:grid;grid-template-columns:1.5fr 1fr 1fr 1fr 1fr 1fr 120px;gap:16px;align-items:center;padding:16px 24px;border-bottom:1px solid rgba(200,169,106,0.08);">

                {{-- Code --}}
                <div style="font-size:13px;color:#f0e6d0;font-family:monospace;letter-spacing:1px;">
                    {{ $coupon->code }}
                </div>

                {{-- Type --}}
                <div style="font-size:12px;color:#9a8870;font-family:Arial,sans-serif;">
                    {{ $coupon->type === 'fixed' ? __('Fixed') : __('Percent') }}
                </div>

                {{-- Value --}}
                <div style="font-size:13px;color:#C8A96A;font-family:Arial,sans-serif;">
                    {{ $coupon->type === 'fixed' ? '$' : '' }}{{ $coupon->value }}{{ $coupon->type === 'percent' ? '%' : '' }}
                </div>

                {{-- Usage --}}
                <div style="font-size:12px;color:#9a8870;font-family:Arial,sans-serif;">
                    {{ $coupon->used_count }}
                    @if($coupon->usage_limit)
                        / {{ $coupon->usage_limit }}
                    @else
                        / ∞
                    @endif
                </div>

                {{-- Expires --}}
                <div style="font-size:12px;font-family:Arial,sans-serif;
                    color:{{ $coupon->expires_at && now()->gt($coupon->expires_at) ? '#c45040' : '#9a8870' }}">
                    {{ $coupon->expires_at ? $coupon->expires_at->format('d M Y') : '—' }}
                </div>

                {{-- Status --}}
                <div>
                    @if($coupon->is_valid)
                        <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;background:rgba(122,184,122,0.1);color:#7ab87a;">
                            {{ __('Active') }}
                        </span>
                    @else
                        <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;background:rgba(196,80,64,0.1);color:#c45040;">
                            {{ __('Inactive') }}
                        </span>
                    @endif
                </div>

                {{-- Actions --}}
                <div style="display:flex;gap:8px;">
                    <a href="{{ route('admin.coupons.edit', $coupon->id) }}"
                       style="padding:6px 12px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:11px;font-family:Arial,sans-serif;text-decoration:none;">
                        {{ __('Edit') }}
                    </a>
                    <form method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}"
                          onsubmit="return confirm('{{ __('Delete this coupon?') }}')">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            style="padding:6px 12px;background:transparent;border:1px solid rgba(196,80,64,0.2);border-radius:6px;color:#c45040;font-size:11px;font-family:Arial,sans-serif;cursor:pointer;">
                            {{ __('Delete') }}
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div style="text-align:center;padding:60px;color:#5a5040;font-family:Arial,sans-serif;font-size:14px;">
                {{ __('No coupons yet') }}
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($coupons->hasPages())
        <div style="margin-top:24px;">
            {{ $coupons->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
@endsection