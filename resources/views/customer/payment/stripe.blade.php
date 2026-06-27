@extends('layouts.customer.app')
@section('title', __('Card Payment'))

@push('styles')
<style>
    .stripe-wrap {
        max-width: 500px;
        margin: 60px auto 80px;
        padding: 0 24px;
    }

    .stripe-hero {
        text-align: center;
        margin-bottom: 32px;
    }
    .stripe-eyebrow {
        font-size: 10px;
        letter-spacing: 4px;
        text-transform: uppercase;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        margin-bottom: 10px;
    }
    .stripe-title {
        font-family: 'Georgia', serif;
        font-size: 28px;
        font-weight: 400;
        color: var(--text-primary);
    }
    .stripe-rule {
        width: 36px;
        height: 1px;
        background: var(--gold);
        opacity: 0.5;
        margin: 10px auto 0;
    }

    .stripe-card {
        background: var(--bg-card);
        border: 1px solid var(--border);
        border-radius: 12px;
        padding: 28px;
        margin-bottom: 16px;
    }

    /* Total */
    .stripe-total {
        text-align: center;
        padding-bottom: 24px;
        margin-bottom: 24px;
        border-bottom: 1px solid var(--border);
    }
    .stripe-total-label {
        font-size: 11px;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        margin-bottom: 6px;
    }
    .stripe-total-amount {
        font-size: 36px;
        color: var(--gold);
        font-family: 'Georgia', serif;
    }

    /* Stripe Element */
    #card-element {
        background: rgba(200,169,106,0.04);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 12px;
        transition: border-color 0.15s;
    }
    #card-element.focused {
        border-color: var(--gold-dim);
    }

    #card-errors {
        color: var(--danger, #e05c5c);
        font-size: 12px;
        font-family: Arial, sans-serif;
        margin-bottom: 16px;
        min-height: 18px;
    }

    .pay-btn {
        display: block;
        width: 100%;
        padding: 14px;
        background: var(--gold);
        border: none;
        border-radius: 8px;
        color: #0a0a0a;
        font-size: 12px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        font-family: Arial, sans-serif;
        cursor: pointer;
        transition: opacity 0.2s;
    }
    .pay-btn:hover { opacity: 0.88; }
    .pay-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .secure-note {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        margin-top: 14px;
        font-size: 11px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
    }

    .back-link {
        display: block;
        text-align: center;
        margin-top: 16px;
        font-size: 12px;
        color: var(--gold-dim);
        font-family: Arial, sans-serif;
        text-decoration: none;
        transition: color 0.15s;
    }
    .back-link:hover { color: var(--gold); }

    /* Test cards hint */
    .test-hint {
        background: rgba(200,169,106,0.06);
        border: 1px solid var(--border);
        border-radius: 8px;
        padding: 14px 16px;
        margin-bottom: 16px;
        font-size: 11px;
        color: var(--text-muted);
        font-family: Arial, sans-serif;
        line-height: 1.8;
    }
    .test-hint strong { color: var(--gold-dim); }
</style>
@endpush

@section('content')
<div class="stripe-wrap">

    {{-- Hero --}}
    <div class="stripe-hero">
        <div class="stripe-eyebrow">{{ __('Secure Payment') }}</div>
        <h1 class="stripe-title">{{ __('Card Details') }}</h1>
        <div class="stripe-rule"></div>
    </div>

    @if(config('app.env') === 'local')
        <div class="test-hint">
            <strong>🧪 {{ __('Test Mode') }}</strong><br>
            ✅ {{ __('Success') }}: 4242 4242 4242 4242<br>
            ❌ {{ __('Decline') }}: 4000 0000 0000 0002<br>
            {{ __('Expiry') }}: 12/34 — CVC: 123
        </div>
    @endif

    <div class="stripe-card">

        {{-- Total --}}
        <div class="stripe-total">
            <div class="stripe-total-label">{{ __('Total to pay') }}</div>
            <div class="stripe-total-amount">
                ${{ number_format($order->total, 2) }}
            </div>
        </div>

        {{-- Stripe Form --}}
        <form id="payment-form">

            {{-- Stripe Elements بيـ mount هنا --}}
            <div id="card-element"></div>

            {{-- Error messages من Stripe --}}
            <div id="card-errors" role="alert"></div>

            <button type="submit" class="pay-btn" id="pay-btn">
                {{ __('Pay') }} ${{ number_format($order->total, 2) }}
            </button>

        </form>

        <div class="secure-note">
            🔒 {{ __('Secured by Stripe — your card details are never stored on our servers') }}
        </div>

    </div>

    <a href="{{ route('checkout.index') }}" class="back-link">
        ← {{ __('Back to Checkout') }}
    </a>

</div>
@endsection

@push('scripts')
<script src="https://js.stripe.com/v3/"></script>
<script>
    const stripeKey    = '{{ $stripeKey }}';
    const clientSecret = '{{ $clientSecret }}';
    const confirmUrl   = '{{ route("payment.stripe.confirm", $order->id) }}';
    const orderTotal   = '${{ number_format($order->total, 2) }}';

    
    const stripe   = Stripe(stripeKey);
    const elements = stripe.elements();

    const cardElement = elements.create('card', {
        style: {
            base: {
                color: '#f0e6d0',
                fontFamily: 'Arial, sans-serif',
                fontSize: '14px',
                '::placeholder': {
                    color: '#5a5040'
                },
            },
            invalid: {
                color: '#c45040',
                iconColor: '#c45040',
            },
        }
    });

    cardElement.mount('#card-element');

    // ── Error handling ──
    cardElement.on('change', function(event) {
        const errorDiv = document.getElementById('card-errors');
        errorDiv.textContent = event.error ? event.error.message : '';
    });

    // ── Focus styling ──
    cardElement.on('focus', () => {
        document.getElementById('card-element').classList.add('focused');
    });
    cardElement.on('blur', () => {
        document.getElementById('card-element').classList.remove('focused');
    });

    // ── Handle Submit ──
    document.getElementById('payment-form').addEventListener('submit', async function(e) {
        e.preventDefault();

        const btn = document.getElementById('pay-btn');

        btn.textContent = '{{ __("Processing...") }}';

        
        const { paymentIntent, error } = await stripe.confirmCardPayment(
            clientSecret,
            {
                payment_method: {
                    card: cardElement
                }
            }
        );

        if (error) {
            
            document.getElementById('card-errors').textContent = error.message;
            btn.disabled    = false;
            btn.textContent = `{{ __('Pay') }} ${orderTotal}`;

        } else if (paymentIntent.status === 'succeeded') {
            window.location.href = confirmUrl
                + '?payment_intent=' + paymentIntent.id;
        }
    });
</script>
@endpush