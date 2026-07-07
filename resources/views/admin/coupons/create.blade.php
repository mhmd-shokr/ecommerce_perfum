@extends('layouts.admin.app')
@section('title', __('Create Coupon'))

@section('content')
<div style="padding:32px;max-width:600px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
        <a href="{{ route('admin.coupons.index') }}"
           style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
            ← {{ __('Back') }}
        </a>
        <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
            {{ __('Create Coupon') }}
        </h1>
    </div>

    {{-- Form --}}
    <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;">

        <form method="POST" action="{{ route('admin.coupons.store') }}">
            @csrf

            {{-- Code --}}
            <div style="margin-bottom:20px;">
                <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                    {{ __('Coupon Code') }} *
                </label>
                <div style="display:flex;gap:8px;">
                    <input type="text" name="code"
                        value="{{ old('code') }}"
                        placeholder="SAVE20"
                        style="flex:1;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:monospace;letter-spacing:1px;outline:none;">
                    <button type="button" onclick="generateCode()"
                        style="padding:10px 14px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:11px;font-family:Arial,sans-serif;cursor:pointer;white-space:nowrap;">
                        {{ __('Generate') }}
                    </button>
                </div>
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
                        <option value="fixed"   style="background:#121212;" {{ old('type') == 'fixed'   ? 'selected' : '' }}>
                            {{ __('Fixed ($)') }}
                        </option>
                        <option value="percent" style="background:#121212;" {{ old('type') == 'percent' ? 'selected' : '' }}>
                            {{ __('Percentage (%)') }}
                        </option>
                    </select>
                    @error('type')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Value') }} *
                    </label>
                    <input type="number" name="value" step="0.01" min="0"
                        value="{{ old('value') }}"
                        placeholder="10"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                    @error('value')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Usage Limit + Expires --}}
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Usage Limit') }}
                        <span style="color:#5a5040;text-transform:none;letter-spacing:0;">({{ __('optional') }})</span>
                    </label>
                    <input type="number" name="usage_limit" min="1"
                        value="{{ old('usage_limit') }}"
                        placeholder="{{ __('Unlimited') }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                    @error('usage_limit')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Expires At') }}
                        <span style="color:#5a5040;text-transform:none;letter-spacing:0;">({{ __('optional') }})</span>
                    </label>
                    <input type="date" name="expires_at"
                        value="{{ old('expires_at') }}"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;">
                    @error('expires_at')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            {{-- Is Active --}}
            <div style="margin-bottom:28px;">
                <label style="display:flex;align-items:center;gap:10px;cursor:pointer;">
                    <input type="checkbox" name="is_active" value="1"
                        {{ old('is_active', true) ? 'checked' : '' }}
                        style="width:16px;height:16px;accent-color:#C8A96A;">
                    <span style="font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">
                        {{ __('Active') }}
                    </span>
                </label>
            </div>

            {{-- Submit --}}
            <button type="submit"
                style="width:100%;padding:14px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                {{ __('Create Coupon') }}
            </button>

        </form>
    </div>
</div>

@push('scripts')
<script>
    function generateCode() {
        const chars  = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        let code     = '';
        for (let i = 0; i < 8; i++) {
            code += chars.charAt(Math.floor(Math.random() * chars.length));
        }
        document.querySelector('input[name="code"]').value = code;
    }
</script>
@endpush
@endsection