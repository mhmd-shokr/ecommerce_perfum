@extends('layouts.admin.app')
@section('title', __('Offer Details'))

@section('content')
<div style="padding:32px;max-width:700px;">

    {{-- Header --}}
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:28px;">
        <div style="display:flex;align-items:center;gap:16px;">
            <a href="{{ route('admin.offers.index') }}"
               style="padding:8px 16px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:12px;font-family:Arial,sans-serif;text-decoration:none;">
                ← {{ __('Back') }}
            </a>
            <h1 style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;">
                {{ $offer->title }}
            </h1>
        </div>

        {{-- Send Button --}}
        @if(!$offer->is_sent && !$offer->is_expired)
            <form method="POST" action="{{ route('admin.offers.send', $offer->id) }}"
                  onsubmit="return confirm('{{ __('Send to all users?') }}')">
                @csrf
                <button type="submit"
                    style="padding:10px 24px;background:#C8A96A;border:none;border-radius:7px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                    🚀 {{ __('Send to All Users') }}
                </button>
            </form>
        @endif
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#7ab87a;font-family:Arial,sans-serif;margin-bottom:20px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Stats --}}
    <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:24px;">
        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:10px;padding:16px;text-align:center;">
            <div style="font-size:24px;color:#C8A96A;font-family:Georgia,serif;">
                {{ number_format($offer->recipients_count) }}
            </div>
            <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#5a5040;font-family:Arial,sans-serif;margin-top:4px;">
                {{ __('Recipients') }}
            </div>
        </div>
        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:10px;padding:16px;text-align:center;">
            <div style="font-size:16px;font-family:Arial,sans-serif;margin-top:4px;
                color:{{ $offer->is_expired ? '#c45040' : ($offer->is_sent ? '#7ab87a' : '#8a7248') }}">
                {{ $offer->is_expired ? __('Expired') : ($offer->is_sent ? __('Sent') : __('Draft')) }}
            </div>
            <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#5a5040;font-family:Arial,sans-serif;margin-top:4px;">
                {{ __('Status') }}
            </div>
        </div>
        <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:10px;padding:16px;text-align:center;">
            <div style="font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">
                {{ $offer->sent_at ? $offer->sent_at->format('d M Y') : '—' }}
            </div>
            <div style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#5a5040;font-family:Arial,sans-serif;margin-top:4px;">
                {{ __('Sent At') }}
            </div>
        </div>
    </div>

    {{-- Offer Details --}}
    <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">

        {{-- Image --}}
        @if($offer->image)
            <img src="{{ asset('storage/' . $offer->image) }}"
                 style="width:100%;max-height:280px;object-fit:cover;display:block;">
        @endif

        <div style="padding:24px;">

            {{-- Title --}}
            <div style="font-size:20px;color:#f0e6d0;font-family:Georgia,serif;margin-bottom:12px;">
                {{ $offer->title }}
            </div>

            {{-- Description --}}
            <div style="font-size:14px;color:#9a8870;font-family:Arial,sans-serif;line-height:1.8;margin-bottom:20px;">
                {{ $offer->description }}
            </div>

            {{-- Button --}}
            @if($offer->button_text)
                <div style="margin-bottom:20px;">
                    <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                        {{ __('Button') }}:
                    </span>
                    <span style="font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;margin-left:8px;">
                        {{ $offer->button_text }}
                    </span>
                    <span style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;margin-left:8px;">
                        → {{ $offer->button_url }}
                    </span>
                </div>
            @endif

            {{-- Expires --}}
            <div>
                <span style="font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
                    {{ __('Expires') }}:
                </span>
                <span style="font-size:13px;font-family:Arial,sans-serif;margin-left:8px;
                    color:{{ $offer->is_expired ? '#c45040' : '#9a8870' }}">
                    {{ $offer->expires_at->format('d M Y, h:i A') }}
                    @if($offer->is_expired)
                        ({{ __('Expired') }})
                    @endif
                </span>
            </div>

        </div>
    </div>

</div>
@endsection