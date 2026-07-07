@extends('layouts.admin.app')
@section('title', __('Edit Coupon'))

@section('content')
<div style="padding:32px;max-width:600px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
        <a href="{{ route('admin.coupons.index') }}"
           style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
            ← {{ __('Back') }}
        </a>
        <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
            {{ __('Edit Coupon') }} — <span style="color:#C8A96A;">{{ $coupon->code }}</span>
        </h1>
    </div>

    {{-- Stats --}}
    <div style="display:flex;gap:12px;margin-bottom:20px;">
        <div style="flex:1;background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:8px;padding:14px;text-align:center;">
            <div style="font-size:24px;color:#C8A96A;font-family:Georgia,serif;">{{ $coupon->used_count }}</div>
            <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#5a5040;font-family:Arial,sans-serif;margin-top:4px;">{{ __('Times Used') }}</div>
        </div>
        <div style="flex:1;background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:8px;padding:14px;text-align:center;">
            <div style="font-size:24px;color:{{ $coupon->is_valid ? '#7ab87a' : '#c45040' }};font-family:Georgia,serif;">
                {{ $coupon->is_valid ? '✓' : '✗' }}
            </div>
            <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#5a5040;font-family:Arial,sans-serif;margin-top:4px;">{{ __('Status') }}</div>
        </div>
    </div>

    {{-- Form --}}
    <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;">

        <form method="POST" action="{{ route('admin.coupons.update', $coupon->id) }}">
            @csrf
            @method('PUT')

            {{-- Code --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                    {{ __('Coupon Code') }} *
                </label>
                <input type="text" name="code"
                    value="{{ old('code', $coupon->code) }}"
                    style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:monospace;letter-spacing:1px;outline:none;">
                @error('code')
                    <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type + Value --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Type') }} *
                    </label>
                    <select name="type"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                        <option value="fixed"   style="background:#121212;" {{ old('type', $coupon->type) == 'fixed'   ? 'selected' : '' }}>{{ __('Fixed ($)') }}</option>
                        <option value="percent" style="background:#121212;" {{ old('type', $coupon->type) == 'percent' ? 'selected' : '' }}>{{ __('Percentage (%)') }}</option>
                    </select>
                </div>
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Value') }} *
                    </label>
                    <input type="number" name="value" step="0.01" min="0"
                        value="{{ old('value', $coupon->value) }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                </div>
            </div>

            {{-- Usage Limit + Expires --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Usage Limit') }}
                    </label>
                    <input type="number" name="usage_limit" min="1"
                        value="{{ old('usage_limit', $coupon->usage_limit) }}"
                        placeholder="{{ __('Unlimited') }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                </div>
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Expires At') }}
                    </label>
                    <input type="date" name="expires_at"
                        value="{{ old('expires_at', $coupon->expires_at?->format('Y-m-d')) }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                </div>
            </div>

            {{-- Is Active --}}
            <div style="margin-bottom:28px;">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', $coupon->is_active) ? 'checked' : '' }}
                        style="width:16px;height:16px;accent-color:#C8A96A;">
                    <span style="font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">
                        {{ __('Active') }}
                    </span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                style="width:100%;padding:14px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                {{ __('Update Coupon') }}
            </button>
        </form>
    </div>
</div>
@endsection