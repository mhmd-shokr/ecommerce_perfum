@extends('layouts.customer.app')
@section('title', __('Verify Email'))

@section('content')
<div style="max-width:440px;margin:80px auto;padding:0 24px;text-align:center;">

    {{-- Icon --}}
    <div style="width:64px;height:64px;background:rgba(200,169,106,0.1);border:1px solid rgba(200,169,106,0.3);border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 20px;font-size:28px;">
        📧
    </div>

    <h1 style="font-family:'Georgia',serif;font-size:26px;font-weight:400;color:var(--text-primary);margin-bottom:8px;">
        {{ __('Verify Your Email') }}
    </h1>
    <p style="font-size:13px;color:var(--text-muted);font-family:Arial,sans-serif;line-height:1.7;margin-bottom:28px;">
        {{ __('Enter the 6-digit code sent to') }}
        <strong style="color:var(--gold);">{{ Auth::user()->email }}</strong>
    </p>

    {{-- Success --}}
    @if(session('success'))
        <div style="background:rgba(122,184,122,0.1);border:1px solid rgba(122,184,122,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:#7ab87a;font-family:Arial,sans-serif;margin-bottom:20px;">
            ✓ {{ session('success') }}
        </div>
    @endif

    {{-- Error --}}
    @if($errors->any())
        <div style="background:rgba(196,80,64,0.08);border:1px solid rgba(196,80,64,0.3);border-radius:8px;padding:12px 18px;font-size:13px;color:var(--danger);font-family:Arial,sans-serif;margin-bottom:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    {{-- OTP Form --}}
    <div style="background:var(--bg-card);border:1px solid var(--border);border-radius:12px;padding:28px;margin-bottom:16px;">

        <form method="POST" action="{{ route('email.verify.otp') }}" id="otp-form">
            @csrf

            {{-- OTP Inputs --}}
            <div style="display:flex;gap:10px;justify-content:center;margin-bottom:24px;">
                @for($i = 1; $i <= 6; $i++)
                    <input type="text"
                        maxlength="1"
                        class="otp-input"
                        style="width:44px;height:52px;text-align:center;font-size:22px;font-weight:700;color:var(--text-primary);background:rgba(200,169,106,0.04);border:1px solid var(--border);border-radius:8px;outline:none;font-family:monospace;"
                        inputmode="numeric"
                        pattern="[0-9]">
                @endfor
            </div>

            <input type="hidden" name="otp" id="otp-hidden">

            <button type="submit"
                style="width:100%;padding:14px;background:var(--gold);border:none;border-radius:8px;color:#0a0a0a;font-size:12px;font-weight:700;letter-spacing:2px;text-transform:uppercase;font-family:Arial,sans-serif;cursor:pointer;">
                {{ __('Verify Email') }}
            </button>
        </form>

    </div>

    {{-- Resend --}}
    <p style="font-size:12px;color:var(--text-muted);font-family:Arial,sans-serif;">
        {{ __("Didn't receive the code?") }}
    </p>
    <form method="POST" action="{{ route('email.verify.resend') }}" style="margin-top:8px;">
        @csrf
        <button type="submit"
            style="background:none;border:none;color:var(--gold-dim);font-size:12px;font-family:Arial,sans-serif;cursor:pointer;text-decoration:underline;">
            {{ __('Resend Code') }}
        </button>
    </form>

    {{-- Logout --}}
    <form method="POST" action="{{ route('logout') }}" style="margin-top:12px;">
        @csrf
        <button type="submit"
            style="background:none;border:none;color:var(--text-muted);font-size:11px;font-family:Arial,sans-serif;cursor:pointer;">
            {{ __('Logout') }}
        </button>
    </form>
    <script>
        const inputs = document.querySelectorAll('.otp-input');
        const hidden = document.getElementById('otp-hidden');
    
        function updateHidden() {
            hidden.value = Array.from(inputs).map(i => i.value).join('');
            console.log('OTP:', hidden.value); // للـ debugging
        }
    
        inputs.forEach((input, index) => {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 1);
    
                if (this.value && index < inputs.length - 1) {
                    inputs[index + 1].focus();
                }
                updateHidden();
            });
    
            input.addEventListener('keydown', function (e) {
                if (e.key === 'Backspace' && !this.value && index > 0) {
                    inputs[index - 1].focus();
                }
            });
    
            input.addEventListener('paste', function (e) {
                e.preventDefault();
                const pasted = e.clipboardData.getData('text').replace(/[^0-9]/g, '');
                pasted.split('').forEach((char, i) => {
                    if (inputs[i]) inputs[i].value = char;
                });
                updateHidden();
                inputs[Math.min(pasted.length, inputs.length - 1)].focus();
            });
        });
    
        document.getElementById('otp-form').addEventListener('submit', function(e) {
        updateHidden();
        if (hidden.value.length !== 6) {
            e.preventDefault();
            alert('{{ __("Please enter the complete 6-digit code") }}');
        }
    });
    
        document.addEventListener('DOMContentLoaded', () => inputs[0]?.focus());
    </script>
</div>




@endsection