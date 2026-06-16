<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('Login') }} — {{ config('app.name') }}</title>
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
            width: 45%;
            background: linear-gradient(135deg, #0d0d0d 0%, #111111 100%);
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
            position: absolute;
            top: -100px; left: -100px;
            width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(200,169,106,0.08) 0%, transparent 70%);
            border-radius: 50%;
        }
        .left-panel::after {
            content: '';
            position: absolute;
            bottom: -80px; right: -80px;
            width: 300px; height: 300px;
            background: radial-gradient(circle, rgba(200,169,106,0.05) 0%, transparent 70%);
            border-radius: 50%;
        }

        .brand {
            display: flex; flex-direction: column; align-items: center;
            text-align: center; position: relative; z-index: 1;
        }
        .brand-icon {
            width: 64px; height: 64px;
            border: 1.5px solid var(--gold);
            border-radius: 50%;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 20px;
        }
        .brand-icon svg { width: 32px; height: 32px; fill: var(--gold); }
        .brand-name {
            font-family: 'Georgia', serif;
            font-size: 28px; letter-spacing: 6px;
            color: var(--gold); text-transform: uppercase;
            margin-bottom: 8px;
        }
        .brand-tagline {
            font-size: 11px; letter-spacing: 2px;
            color: var(--text-muted); text-transform: uppercase;
            margin-bottom: 48px;
        }
        .gold-rule { width: 40px; height: 1px; background: var(--gold); opacity: 0.4; margin: 0 auto 48px; }

        .left-quote {
            font-family: 'Georgia', serif;
            font-size: 20px; color: var(--text-secondary);
            line-height: 1.7; text-align: center;
            max-width: 300px; position: relative; z-index: 1;
        }
        .left-quote span { color: var(--gold); }

        .left-dots {
            display: flex; gap: 8px; margin-top: 40px;
            position: relative; z-index: 1;
        }
        .left-dot { width: 6px; height: 6px; border-radius: 50%; background: var(--text-muted); }
        .left-dot.active { background: var(--gold); width: 20px; border-radius: 3px; }

        /* Right panel - form */
        .right-panel {
            flex: 1;
            display: flex; align-items: center; justify-content: center;
            padding: 60px 40px;
        }

        .form-box { width: 100%; max-width: 400px; }

        .form-header { margin-bottom: 36px; }
        .form-title {
            font-family: 'Georgia', serif;
            font-size: 28px; color: var(--text-primary);
            font-weight: 400; margin-bottom: 6px;
        }
        .form-subtitle { font-size: 13px; color: var(--text-muted); letter-spacing: 0.3px; }
        .form-title-rule { width: 32px; height: 1px; background: var(--gold); margin: 14px 0; opacity: 0.6; }

        /* Status */
        .status-msg {
            background: rgba(122,184,122,0.08);
            border: 1px solid rgba(122,184,122,0.2);
            border-radius: 6px;
            padding: 10px 14px;
            font-size: 12px;
            color: #7ab87a;
            margin-bottom: 20px;
        }

        /* Field */
        .field { margin-bottom: 20px; }
        .field label {
            display: block;
            font-size: 10px; letter-spacing: 2px;
            text-transform: uppercase; color: var(--text-muted);
            margin-bottom: 8px;
        }
        .field input {
            width: 100%;
            background: var(--bg-input);
            border: 1px solid var(--border);
            border-radius: 6px;
            padding: 12px 16px;
            color: var(--text-primary);
            font-size: 13px;
            font-family: Arial, sans-serif;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .field input::placeholder { color: var(--text-muted); }
        .field input:focus {
            border-color: var(--gold-dim);
            box-shadow: 0 0 0 3px rgba(200,169,106,0.06);
        }
        .field input.is-error { border-color: var(--danger); }

        .field-error {
            font-size: 11px; color: var(--danger);
            margin-top: 6px; letter-spacing: 0.3px;
        }

        /* Remember + Forgot */
        .field-row {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }
        .remember-label {
            display: flex; align-items: center; gap: 8px;
            font-size: 12px; color: var(--text-muted); cursor: pointer;
        }
        .remember-label input[type="checkbox"] {
            width: 14px; height: 14px;
            accent-color: var(--gold);
            cursor: pointer;
        }
        .forgot-link {
            font-size: 12px; color: var(--gold-dim);
            text-decoration: none; letter-spacing: 0.3px;
            transition: color 0.2s;
        }
        .forgot-link:hover { color: var(--gold); }

        /* Submit button */
        .btn-submit {
            width: 100%;
            padding: 13px;
            background: var(--gold);
            border: none; border-radius: 6px;
            color: #0a0a0a;
            font-size: 11px; font-weight: 700;
            letter-spacing: 2.5px; text-transform: uppercase;
            font-family: Arial, sans-serif;
            cursor: pointer;
            transition: background 0.2s;
            margin-bottom: 20px;
        }
        .btn-submit:hover { background: var(--gold-light); }

        /* Divider */
        .divider {
            display: flex; align-items: center; gap: 12px;
            margin-bottom: 20px;
        }
        .divider-line { flex: 1; height: 1px; background: var(--border); }
        .divider-text { font-size: 11px; color: var(--text-muted); letter-spacing: 1px; }

        /* Bottom link */
        .form-footer {
            text-align: center;
            font-size: 13px; color: var(--text-muted);
        }
        .form-footer a { color: var(--gold); text-decoration: none; transition: color 0.2s; }
        .form-footer a:hover { color: var(--gold-light); }

        /* Lang switcher */
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
            color: var(--text-muted); text-decoration: none;
            transition: all 0.15s;
        }
        .lang-btn.active { background: rgba(200,169,106,0.12); color: var(--gold); }

        @media (max-width: 768px) {
            .left-panel { display: none; }
            .right-panel { padding: 40px 24px; }
        }
    </style>
</head>
<body>

    <!-- Left decorative panel -->
    <div class="left-panel">
        <div class="brand">
            <div class="brand-icon">
                <svg viewBox="0 0 24 24"><path d="M12 2C12 2 8 6 8 10C8 14 10 16 12 18C14 16 16 14 16 10C16 6 12 2 12 2Z"/></svg>
            </div>
            <div class="brand-name">{{ config('app.name') }}</div>
            <div class="brand-tagline">{{ __('Luxury Fragrances') }}</div>
            <div class="gold-rule"></div>
            <div class="left-quote">
                {{ __('Every scent tells') }} <span>{{ __('a story') }}</span>.<br>
                {{ __('What will yours say?') }}
            </div>
            <div class="left-dots">
                <div class="left-dot active"></div>
                <div class="left-dot"></div>
                <div class="left-dot"></div>
            </div>
        </div>
    </div>

    <!-- Right form panel -->
    <div class="right-panel" style="position:relative;">

        <!-- Lang switcher -->
        <div class="lang-switch">
            <a href="{{ url('lang/en') }}" class="lang-btn {{ app()->getLocale() == 'en' ? 'active' : '' }}">EN</a>
            <a href="{{ url('lang/ar') }}" class="lang-btn {{ app()->getLocale() == 'ar' ? 'active' : '' }}">AR</a>
        </div>

        <div class="form-box">

            <div class="form-header">
                <div class="form-title">{{ __('Welcome back') }}</div>
                <div class="form-title-rule"></div>
                <div class="form-subtitle">{{ __('Sign in to your account to continue') }}</div>
            </div>

            <!-- Session status -->
            @if (session('status'))
                <div class="status-msg">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="field">
                    <label for="email">{{ __('Email Address') }}</label>
                    <input
                        id="email" type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="{{ __('your@email.com') }}"
                        class="{{ $errors->has('email') ? 'is-error' : '' }}"
                        required autofocus autocomplete="username"
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
                        required autocomplete="current-password"
                    >
                    @error('password')
                        <div class="field-error">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Remember + Forgot -->
                <div class="field-row">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember_me">
                        {{ __('Remember me') }}
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">{{ __('Forgot password?') }}</a>
                    @endif
                </div>

                <button type="submit" class="btn-submit">{{ __('Sign In') }}</button>

                <div class="divider">
                    <div class="divider-line"></div>
                    <span class="divider-text">{{ __('OR') }}</span>
                    <div class="divider-line"></div>
                </div>

                <div class="form-footer">
                    {{ __("Do not have an account?") }}
                    <a href="{{ route('register') }}">{{ __('Create one') }}</a>
                </div>

            </form>
        </div>
    </div>

</body>
</html>