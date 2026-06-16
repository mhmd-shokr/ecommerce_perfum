<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Register') }} — {{ config('app.name') }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        :root {
            --gold: #C8A96A;
            --gold-dim: #8a7248;
            --gold-light: #e2c98a;
            --bg: #0a0a0a;
            --bg-card: #111111;
            --bg-input: #161616;
            --border: rgba(200,169,106,0.18);
            --border-strong: rgba(200,169,106,0.35);
            --text-primary: #f0e6d0;
            --text-secondary: #9a8870;
            --text-muted: #5a5040;
            --danger: #c45040;
        }

        body {
            font-family: Arial, sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            min-height: 100vh;
            display: flex;
        }

        /* Left panel */
        .left-panel {
            width: 40%;
            background: linear-gradient(160deg, #0d0d0d 0%, #111111 100%);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 60px;
            position: relative;
            overflow: hidden;
        }
        .left-panel::before {
            content: '';
            position: absolute; top: -100px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(200,169,106,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand {
            display: flex; flex-direction: column; align-items: center;
            text-align: center; position: relative; z-index: 1;
        }
        .brand-icon {
            width: 64px; height: 64px;
            border: 1.5px solid var(--gold); border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }
        .brand-icon svg { width: 32px; height: 32px; fill: var(--gold); }
        .brand-name {
            font-family: 'Georgia', serif;
            font-size: 26px; letter-spacing: 6px;
            color: var(--gold); text-transform: uppercase; margin-bottom: 6px;
        }
        .brand-tagline { font-size: 11px; letter-spacing: 2px; color: var(--text-muted); text-transform: uppercase; margin-bottom: 48px; }
        .gold-rule { width: 40px; height: 1px; background: var(--gold); opacity: 0.4; margin: 0 auto 40px; }

        .perks { width: 100%; position: relative; z-index: 1; }
        .perk {
            display: flex; align-items: flex-start; gap: 14px;
            padding: 14px 0;
            border-bottom: 1px solid rgba(200,169,106,0.08);
        }
        .perk:last-child { border-bottom: none; }
        .perk-icon {
            width: 32px; height: 32px; flex-shrink: 0;
            background: rgba(200,169,106,0.08);
            border: 1px solid var(--border);
            border-radius: 6px;
            display: flex; align-items: center; justify-content: center;
            color: var(--gold);
        }
        .perk-icon svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }
        .perk-title { font-size: 13px; color: var(--text-primary); margin-bottom: 2px; font-family: 'Georgia', serif; }
        .perk-desc { font-size: 11px; color: var(--text-muted); line-height: 1.5; }

        /* Right panel */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 48px 40px;
            overflow-y: auto;
            position: relative;
        }

        .form-box { width: 100%; max-width: 420px; }

        .form-header { margin-bottom: 28px; }
        .form-title { font-family: 'Georgia', serif; font-size: 26px; color: var(--text-primary); font-weight: 400; margin-bottom: 6px; }
        .form-subtitle { font-size: 13px; color: var(--text-muted); }
        .form-title-rule { width: 32px; height: 1px; background: var(--gold); margin: 12px 0; opacity: 0.6; }

        /* Two columns for name fields */
        .field-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        /* Field */
        .field { margin-bottom: 18px; }
        .field label {
            display: block;
            font-size: 10px; letter-spacing: 2px;
            text-transform: uppercase; color: var(--text-muted);
            margin-bottom: 7px;
        }
        .field input {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 11px 14px;
            color: var(--text-primary);
            font-size: 13px; font-family: Arial, sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .field input::placeholder { color: var(--text-muted); }
        .field input:focus {
            border-color: var(--gold-dim);
            box-shadow: 0 0 0 3px rgba(200,169,106,0.06);
        }
        .field input.is-error { border-color: var(--danger); }
        .field-error { font-size: 11px; color: var(--danger); margin-top: 5px; }

        /* Password strength hint */
        .field-hint { font-size: 11px; color: var(--text-muted); margin-top: 5px; letter-spacing: 0.3px; }

        /* Submit */
        .btn-submit {
            width: 100%; padding: 13px;
            background: var(--gold); border: none; border-radius: 6px;
            color: #0a0a0a; font-size: 11px; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            font-family: Arial, sans-serif; cursor: pointer;
            transition: background 0.2s; margin-top: 6px; margin-bottom: 20px;
        }
        .btn-submit:hover { background: var(--gold-light); }

        /* Terms note */
        .terms-note {
            font-size: 11px; color: var(--text-muted);
            text-align: center; margin-bottom: 20px; line-height: 1.6;
        }
        .terms-note a { color: var(--gold-dim); text-decoration: none; }
        .terms-note a:hover { color: var(--gold); }

        /* Divider */
        .divider { display: flex; align-items: center; gap: 12px; margin-bottom: 18px; }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text { font-size: 11px; color: var(--text-muted); letter-spacing: 1px; }

        /* Footer */
        .form-footer { text-align: center; font-size: 13px; color: var(--text-muted); }
        .form-footer a { color: var(--gold); text-decoration: none; transition: color 0.2s; }
        .form-footer a:hover { color: var(--gold-light); }

        /* Lang */
        .lang-switch {
            position: absolute; top: 24px; right: 24px;
            display: flex; gap: 2px;
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border);
            border-radius: 5px; padding: 2px;
        }
        [dir="rtl"] .lang-switch { right: auto; left: 24px; }
        .lang-btn {
            padding: 4px 10px; border-radius: 3px;
            font-size: 10px; letter-spacing: 1px;
            color: var(--text-muted); text-decoration: none; transition: all 0.15s;
        }
        .lang-btn.active { background: rgba(200,169,106,0.12); color: var(--gold); }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 40px 24px; }
            .field-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>

    <!-- Left panel -->
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C12 2 8 6 8 10C8 14 10 16 12 18C14 16 16 14 16 10C16 6 12 2 12 2Z"/></svg>
            </div>
            <div class="brand-name">{{ config('app.name') }}</div>
            <div class="brand-tagline">{{ __('Luxury Fragrances') }}</div>
            <div class="gold-rule"></div>
        </div>

        <div class="perks">
            <div class="perk">
                <div class="perk-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                </div>
                <div>
                    <div class="perk-title">{{ __('Exclusive Access') }}</div>
                    <div class="perk-desc">{{ __('Early access to new launches and limited editions') }}</div>
                </div>
            </div>
            <div class="perk">
                <div class="perk-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                </div>
                <div>
                    <div class="perk-title">{{ __('Wishlist & Favorites') }}</div>
                    <div class="perk-desc">{{ __('Save your favorite scents and track prices') }}</div>
                </div>
            </div>
            <div class="perk">
                <div class="perk-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 8h14M5 8a2 2 0 1 0 0-4h14a2 2 0 1 0 0 4M5 8l1 10c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2L19 8"/></svg>
                </div>
                <div>
                    <div class="perk-title">{{ __('Order Tracking') }}</div>
                    <div class="perk-desc">{{ __('Track your orders and manage returns easily') }}</div>
                </div>
            </div>
            <div class="perk">
                <div class="perk-icon">
                    <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/></svg>
                </div>
                <div>
                    <div class="perk-title">{{ __('Loyalty Rewards') }}</div>
                    <div class="perk-desc">{{ __('Earn points on every purchase and redeem for discounts') }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="right-panel">

        <div class="lang-switch">
            <a href="{{ url('lang/en') }}" class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ url('lang/ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
        </div>

        <div class="form-box">

            <div class="form-header">
                <div class="form-title">{{ __('Create account') }}</div>
                <div class="form-title-rule"></div>
                <div class="form-subtitle">{{ __('Join us and discover the world of luxury fragrance') }}</div>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="field">
                    <label for="name">{{ __('Full Name') }}</label>
                    <input
                        id="name" type="text" name="name"
                        value="{{ old('name') }}"
                        placeholder="{{ __('Your full name') }}"
                        class="{{ $errors->has('name') ? 'is-error' : '' }}"
                        required autofocus autocomplete="name"
                    >
                    @error('name')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Email -->
                <div class="field">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input
                        id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="{{ __('your@email.com') }}"
                        class="{{ $errors->has('email') ? 'is-error' : '' }}"
                        required autocomplete="username"
                    >
                    @error('email')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field">
                    <label for="password">{{ __('Password') }}</label>
                    <input
                        id="password" type="password" name="password"
                        placeholder="••••••••"
                        class="{{ $errors->has('password') ? 'is-error' : '' }}"
                        required autocomplete="new-password"
                    >
                    <div class="field-hint">{{ __('Minimum 8 characters') }}</div>
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="field">
                    <label for="password_confirmation">{{ __('Confirm Password') }}</label>
                    <input
                        id="password_confirmation" type="password"
                        name="password_confirmation"
                        placeholder="••••••••"
                        class="{{ $errors->has('password_confirmation') ? 'is-error' : '' }}"
                        required autocomplete="new-password"
                    >
                    @error('password_confirmation')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <div class="terms-note">
                    {{ __('By creating an account you agree to our') }}
                    <a href="#">{{ __('Terms of Service') }}</a>
                    {{ __('and') }}
                    <a href="#">{{ __('Privacy Policy') }}</a>
                </div>

                <button type="submit" class="btn-submit">{{ __('Create Account') }}</button>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">{{ __('OR') }}</span>
                    <div class="divider-line"></div>
                </div>

                <div class="form-footer">
                    {{ __('Already have an account?') }}
                    <a href="{{ route('login') }}">{{ __('Sign in') }}</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>