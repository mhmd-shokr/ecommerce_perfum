<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('app.name') }}</title>

    <style>
        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family: 'Georgia', serif; background: #0d0d0d; color: #e8dcc8; min-height: 100vh; }

        :root {
            --gold: #C8A96A;
            --gold-dim: #8a7248;
            --bg-panel: #111111;
            --bg-card: #181818;
            --bg-hover: #1f1f1f;
            --border: rgba(200,169,106,0.18);
            --border-strong: rgba(200,169,106,0.35);
            --text-primary: #f0e6d0;
            --text-secondary: #9a8870;
            --text-muted: #5a5040;
            --danger: #c45040;
            --success: #7ab87a;
        }

        .layout { display: flex; min-height: 100vh; }
        .main { margin-left: 240px; display: flex; flex-direction: column; min-height: 100vh; flex: 1; }

        [dir="rtl"] .main { margin-left: 0; margin-right: 240px; }
        [dir="rtl"] .sidebar { left: auto; right: 0; border-right: none; border-left: 1px solid var(--border); }

        .content { padding: 32px; flex: 1; }

        /* Alerts */
        .alert { padding: 12px 18px; border-radius: 8px; font-family: Arial, sans-serif; font-size: 13px; margin-bottom: 20px; border: 1px solid; }
        .alert-success { background: rgba(122,184,122,0.1); color: var(--success); border-color: rgba(122,184,122,0.25); }
        .alert-error   { background: rgba(196,80,64,0.1);  color: var(--danger);  border-color: rgba(196,80,64,0.25);  }
    </style>

    @stack('styles')
</head>
<body>
<div class="layout">

    @include('layouts.admin.sidebar')

    <main class="main">
        @include('layouts.admin.navbar')

        <div class="content">

            {{-- Flash messages --}}
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="alert alert-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </div>
    </main>

</div>

@stack('scripts')
</body>
</html>