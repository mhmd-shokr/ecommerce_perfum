@extends('layouts.admin.app')
@section('title', __('Create Offer'))

@section('content')
    <div style="padding:32px;max-width:700px;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
            <a href="{{ route('admin.offers.index') }}"
                style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
                ← {{ __('Back') }}
            </a>
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ __('Create Offer') }}
            </h1>
        </div>

        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;">
            <form method="POST" action="{{ route('admin.offers.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Title') }} *
                    </label>
                    <input type="text" name="title" value="{{ old('title') }}" placeholder="{{ __('Summer Sale 20% Off') }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('title')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Description') }} *
                    </label>
                    <textarea name="description" rows="4" placeholder="{{ __('Describe your offer...') }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;resize:vertical;box-sizing:border-box;">{{ old('description') }}</textarea>
                    @error('description')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Coupon --}}
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Coupon Code') }} *
                    </label>
                    <select name="coupon_id" id="coupon-id">
                        <option value="">
                            {{ __('Select Coupon') }}
                        </option>
                        @foreach($coupons as $coupon)
                            <option value="{{ $coupon->id }}">
                                {{ $coupon->code }}
                            </option>
                        @endforeach
                    </select>
                    @error('coupon_id')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Image --}}
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Image') }}
                        <span style="color:#5a5040;text-transform:none;letter-spacing:0;">({{ __('optional') }})</span>
                    </label>
                    <input type="file" name="image" accept="image/*"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#9a8870;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('image')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Button Text + URL --}}
                <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                    <div>
                        <label
                            style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                            {{ __('Button Text') }}
                            <span style="color:#5a5040;text-transform:none;letter-spacing:0;">({{ __('optional') }})</span>
                        </label>
                        <input type="text" name="button_text" value="{{ old('button_text') }}"
                            placeholder="{{ __('Shop Now') }}"
                            style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    </div>
                    <div>
                        <label
                            style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                            {{ __('Button URL') }}
                            <span style="color:#5a5040;text-transform:none;letter-spacing:0;">({{ __('optional') }})</span>
                        </label>
                        <input type="url" name="button_url" value="{{ old('button_url') }}"
                            placeholder="https://yourstore.com/shop"
                            style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    </div>
                </div>

                {{-- Expires At --}}
                <div style="margin-bottom:28px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Expires At') }} *
                    </label>
                    <input type="datetime-local" name="expires_at" value="{{ old('expires_at') }}"
                        min="{{ now()->addHour()->format('Y-m-d\TH:i') }}"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('expires_at')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    style="width:100%;padding:14px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                    {{ __('Save as Draft') }}
                </button>

            </form>
        </div>
    </div>
@endsection