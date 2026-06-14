<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home') — {{ config('app.name') }}</title>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }

        :root {
            --gold: #C8A96A;
            --gold-dim: #8a7248;
            --gold-light: #e2c98a;
            --bg: #0a0a0a;
            --bg-card: #121212;
            --bg-hover: #1a1a1a;
            --border: rgba(200,169,106,0.15);
            --border-strong: rgba(200,169,106,0.3);
            --text-primary: #f0e6d0;
            --text-secondary: #9a8870;
            --text-muted: #5a5040;
            --danger: #c45040;
            --success: #7ab87a;
        }

        body { font-family: 'Georgia', serif; background: var(--bg); color: var(--text-primary); min-height: 100vh; display: flex; flex-direction: column; }
        main { flex: 1; }

        .alert { padding: 12px 18px; border-radius: 8px; font-family: Arial, sans-serif; font-size: 13px; margin: 16px 32px; border: 1px solid; }
        .alert-success { background: rgba(122,184,122,0.1); color: var(--success); border-color: rgba(122,184,122,0.25); }
        .alert-error   { background: rgba(196,80,64,0.1);  color: var(--danger);  border-color: rgba(196,80,64,0.25); }
    </style>

    @stack('styles')
</head>
<body>

    @include('layouts.customer.navbar')

    <main>
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif

        @yield('content')
    </main>

    @include('layouts.customer.footer')

    @stack('scripts')
</body>
</html>