@extends('layouts.admin.app')
@section('title', __('Offers'))

@section('content')
<div style="padding:32px;">

    {{-- Header --}}
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
        <div>
            <h1 style="font-size:22px;color:#f0e6d0;font-family:Georgia,serif;font-weight:400;margin-bottom:4px;">
                {{ __('Offers') }}
            </h1>
            <p style="font-size:12px;color:#5a5040;font-family:Arial,sans-serif;">
                {{ $offers->total() }} {{ __('total offers') }}
            </p>
        </div>
        <a href="{{ route('admin.offers.create') }}"
           style="padding:10px 20px;background:#C8A96A;border-radius:7px;color:#0a0a0a;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;font-family:Arial,sans-serif;text-decoration:none;">
            + {{ __('New Offer') }}
        </a>
    </div>

    {{-- Flash --}}
    @if(session('success'))
        <div style="background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#7ab87a;font-family:Arial,sans-serif;margin-bottom:20px;">
            ✓ {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background:rgba(196,80,64,0.08);border:1px solid rgba(196,80,64,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#c45040;font-family:Arial,sans-serif;margin-bottom:20px;">
            ⚠ {{ session('error') }}
        </div>
    @endif

    {{-- Table --}}
    <div style="background:#121212;border:1px solid rgba(200,169,106,0.15);border-radius:12px;overflow:hidden;">

        {{-- Header --}}
        <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 140px;gap:16px;padding:14px 24px;border-bottom:1px solid rgba(200,169,106,0.15);font-size:10px;letter-spacing:2px;text-transform:uppercase;color:#8a7248;font-family:Arial,sans-serif;">
            <span>{{ __('Offer') }}</span>
            <span>{{ __('Status') }}</span>
            <span>{{ __('Recipients') }}</span>
            <span>{{ __('coupon') }}</span>
            <span>{{ __('Expires') }}</span>
            <span></span>
        </div>

        @forelse($offers as $offer)
            <div style="display:grid;grid-template-columns:2fr 1fr 1fr 1fr 140px;gap:16px;align-items:center;padding:16px 24px;border-bottom:1px solid rgba(200,169,106,0.08);">

                {{-- Title --}}
                <div>
                    <div style="font-size:13px;color:#f0e6d0;font-family:Arial,sans-serif;margin-bottom:3px;">
                        {{ $offer->title }}
                    </div>
                    <div style="font-size:11px;color:#5a5040;font-family:Arial,sans-serif;">
                        {{ __('Created') }}: {{ $offer->created_at->format('d M Y') }}
                    </div>
                </div>
                

                {{-- Status --}}
                <div>
                    @if($offer->is_expired)
                        <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;background:rgba(196,80,64,0.1);color:#c45040;">
                            {{ __('Expired') }}
                        </span>
                    @elseif($offer->is_sent)
                        <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;background:rgba(122,184,122,0.1);color:#7ab87a;">
                            {{ __('Sent') }}
                        </span>
                    @else
                        <span style="display:inline-block;padding:4px 10px;border-radius:20px;font-size:10px;font-family:Arial,sans-serif;letter-spacing:1px;text-transform:uppercase;background:rgba(200,169,106,0.1);color:#8a7248;">
                            {{ __('Draft') }}
                        </span>
                    @endif
                </div>

                {{-- Recipients --}}
                <div style="font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">
                    {{ $offer->recipients_count > 0 ? number_format($offer->recipients_count) . ' ' . __('users') : '—' }}
                </div>

                <div style="font-size:13px;color:#9a8870;font-family:Arial,sans-serif;">
                    {{ $offer->coupon?->code ?? '—' }}
                </div>



                {{-- Expires --}}
                <div style="font-size:12px;font-family:Arial,sans-serif;color:{{ $offer->is_expired ? '#c45040' : '#9a8870' }}">
                    {{ $offer->expires_at->format('d M Y') }}
                </div>

                {{-- Actions --}}
                <div style="display:flex;gap:8px;align-items:center;">

                    {{-- View --}}
                    <a href="{{ route('admin.offers.show', $offer->id) }}"
                       style="padding:6px 12px;background:transparent;border:1px solid rgba(200,169,106,0.2);border-radius:6px;color:#8a7248;font-size:11px;font-family:Arial,sans-serif;text-decoration:none;">
                        {{ __('View') }}
                    </a>

                    {{-- Send --}}
                    @if(!$offer->is_sent && !$offer->is_expired)
                        <form method="POST" action="{{ route('admin.offers.send', $offer->id) }}"
                              onsubmit="return confirm('{{ __('Send to all users?') }}')">
                            @csrf
                            <button type="submit"
                                style="padding:6px 12px;background:#C8A96A;border:none;border-radius:6px;color:#0a0a0a;font-size:11px;font-family:Arial,sans-serif;cursor:pointer;font-weight:700;">
                                {{ __('Send') }}
                            </button>
                        </form>
                    @endif

                    {{-- Delete --}}
                    @if(!$offer->is_sent)
                        <form method="POST" action="{{ route('admin.offers.destroy', $offer->id) }}"
                              onsubmit="return confirm('{{ __('Delete this offer?') }}')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                style="padding:6px 12px;background:transparent;border:1px solid rgba(196,80,64,0.2);border-radius:6px;color:#c45040;font-size:11px;font-family:Arial,sans-serif;cursor:pointer;">
                                {{ __('Delete') }}
                            </button>
                        </form>
                    @endif

                </div>

            </div>
        @empty
            <div style="text-align:center;padding:60px;color:#5a5040;font-family:Arial,sans-serif;font-size:14px;">
                {{ __('No offers yet') }}
            </div>
        @endforelse

    </div>

    {{-- Pagination --}}
    @if($offers->hasPages())
        <div style="margin-top:24px;">
            {{ $offers->links('pagination::bootstrap-5') }}
        </div>
    @endif

</div>
@endsection