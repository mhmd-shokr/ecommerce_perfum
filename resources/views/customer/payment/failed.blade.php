@extends('layouts.customer.app')
@section('title', __('Payment Failed'))

@push('styles')
<style>
    .failed-wrap {
        max-width: 500px;
        margin: 80px auto 80px;
        padding: 0 24px;
        text-align: center;
    }

    .failed-icon {
        width: 64px;
        height: 64px;
        background: rgba(196,80,64,0.1);
        border: 1px solid rgba(196,80,64,0.3);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 28px;
    }

    .failed-title {
        font-family: 'Georgia', serif;
        font-size: 26px;
        font-weight: 400;
        color: var(--text-primary);
        margin-bottom: 8px;
    }

    .failed-sub {
        font-size: 13px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 12px;
        line-height: 1.7;
    }

    .failed-error {
        background: rgba(196,80,64,0.08);
        border: 1px solid rgba(196,80,64,0.2);
        border-radius: 8px;
        padding: 12px 18px;
        font-size: 12px;
        color: var(--danger, #e05c5c);
        font-family: Arial, sans-serif;
        margin-bottom: 32px;
    }

    .failed-order {
        display: inline-block;
        padding: 6px 16px;
        background: rgba(200,169,106,0.06);
        border: 1px solid var(--border);
        border-radius: 6px;
        font-size: 11px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 32px;
        letter-spacing: 0.5px;
    }

    .failed-actions {
        display: flex;
        gap: 12px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn-gold {
        padding: 12px 24px;
        background: var(--gold);
        border: none;
        border-radius: 7px;
        color: #0a0a0a;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: opacity 0.2s;
        cursor: pointer;
    }
    .btn-gold:hover { opacity: 0.88; }

    .btn-outline {
        padding: 12px 24px;
        background: transparent;
        border: 1px solid var(--border-strong);
        border-radius: 7px;
        color: var(--gold);
        font-size: 11px;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: all 0.2s;
    }
    .btn-outline:hover { background: rgba(200,169,106,0.08); }
</style>
@endpush

@section('content')
<div class="failed-wrap">

    {{-- Icon --}}
    <div class="failed-icon">✗</div>

    <h1 class="failed-title">{{ __('Payment Failed') }}</h1>

    <p class="failed-sub">
        {{ __('Something went wrong with your payment.') }}<br>
        {{ __('Your order has been saved — you can try again.') }}
    </p>

    {{-- Error Message --}}
    @if(session('error'))
        <div class="failed-error">
            {{ session('error') }}
        </div>
    @endif

    {{-- Order Reference --}}
    <div class="failed-order">
        {{ __('Order') }} #{{ $order->order_number }}
    </div>

    {{-- Actions --}}
    <div class="failed-actions">

        {{-- Try Stripe Again --}}
        <a href="{{ route('payment.stripe', $order->id) }}" class="btn-gold">
            💳 {{ __('Try Card Again') }}
        </a>

        {{-- Pay with Cash Instead --}}
        <form method="POST" action="{{ route('payment.cash', $order->id) }}">
            @csrf
            <button type="submit" class="btn-outline">
                💵 {{ __('Pay with Cash') }}
            </button>
        </form>

    </div>

</div>
@endsection