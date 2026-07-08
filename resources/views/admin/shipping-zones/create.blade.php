@extends('layouts.admin.app')
@section('title', __('Add Shipping Zone'))

@section('content')
    <div style="padding:32px;max-width:700px;">

        {{-- Header --}}
        <div style="display:flex;align-items:center;gap:16px;margin-bottom:28px;">
            <a href="{{ route('admin.shipping-zones.index') }}"
                style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
                ← {{ __('Back') }}
            </a>
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ __('Add Shipping Zone') }}
            </h1>
        </div>

        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;padding:28px;">
            <form method="POST" action="{{ route('admin.shipping-zones.store') }}">
                @csrf

                {{-- Governorate --}}
                <div style="margin-bottom:20px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Governorate') }} *
                    </label>
                    <select name="governorate" id="governorate"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;
                               appearance:none;-webkit-appearance:none;-moz-appearance:none;
                               background-image:url('data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2212%22 height=%228%22 viewBox=%220 0 12 8%22><path d=%22M1 1l5 5 5-5%22 stroke=%22%238a7248%22 stroke-width=%221.5%22 fill=%22none%22/></svg>');
                               background-repeat:no-repeat;background-position:right 14px center;
                               cursor:pointer;">
                        <option value="" style="background:#121212;color:#9a8870;">
                            {{ __('Select Governorate') }}
                        </option>
                        @foreach($governorates as $governorate)
                            <option value="{{ $governorate }}" @selected(old('governorate') == $governorate)
                                style="background:#121212;color:#f0e6d0;">
                                {{ __($governorate) }}
                            </option>
                        @endforeach
                    </select>
                    @error('governorate')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Cost --}}
                <div style="margin-bottom:28px;">
                    <label
                        style="display:block;font-size:10px;letter-spacing:1.5px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;margin-bottom:8px;">
                        {{ __('Shipping Cost') }} *
                    </label>
                    <input type="number" name="cost" value="{{ old('cost') }}" step="0.01" min="0" placeholder="0.00"
                        style="width:100%;background:rgba(200,169,106,0.04);border:1px solid rgba(200,169,106,0.15);border-radius:6px;padding:10px 14px;color:#f0e6d0;font-size:13px;font-family:Arial,sans-serif;outline:none;box-sizing:border-box;">
                    @error('cost')
                        <p style="font-size:11px;color:#c45040;font-family:Arial,sans-serif;margin-top:4px;">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Submit --}}
                <button type="submit"
                    style="width:100%;padding:14px;background:#C8A96A;border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                    {{ __('Save Zone') }}
                </button>

            </form>
        </div>
    </div>
@endsection