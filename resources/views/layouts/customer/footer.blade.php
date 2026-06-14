<style>
    .c-footer {
        background: #080808;
        border-top: 1px solid var(--border);
        padding: 60px 32px 32px;
        margin-top: auto;
    }
    .c-footer-inner { max-width: 1280px; margin: 0 auto; }

    .c-footer-grid {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 48px;
        margin-bottom: 48px;
    }

    .c-footer-brand-icon {
        width: 36px; height: 36px;
        border: 1.5px solid var(--gold);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
    }
    .c-footer-brand-icon svg { width: 18px; height: 18px; fill: var(--gold); }
    .c-footer-brand-name { font-size: 14px; letter-spacing: 3px; color: var(--gold); text-transform: uppercase; margin-bottom: 12px; }
    .c-footer-tagline { font-size: 13px; color: var(--text-muted); font-family: Arial, sans-serif; line-height: 1.7; max-width: 240px; }

    .c-footer-socials { display: flex; gap: 10px; margin-top: 20px; }
    .c-footer-social {
        width: 32px; height: 32px;
        border: 1px solid var(--border);
        border-radius: 5px;
        display: flex; align-items: center; justify-content: center;
        color: var(--text-muted);
        text-decoration: none;
        transition: all 0.2s;
    }
    .c-footer-social:hover { border-color: var(--gold-dim); color: var(--gold); }
    .c-footer-social svg { width: 14px; height: 14px; stroke: currentColor; fill: none; }

    .c-footer-col-title { font-size: 10px; letter-spacing: 2.5px; text-transform: uppercase; color: var(--gold-dim); font-family: Arial, sans-serif; margin-bottom: 20px; }
    .c-footer-links { list-style: none; display: flex; flex-direction: column; gap: 10px; }
    .c-footer-links a { color: var(--text-muted); text-decoration: none; font-family: Arial, sans-serif; font-size: 13px; transition: color 0.2s; }
    .c-footer-links a:hover { color: var(--text-secondary); }

    .c-footer-bottom {
        border-top: 1px solid var(--border);
        padding-top: 24px;
        display: flex; justify-content: space-between; align-items: center;
        font-family: Arial, sans-serif;
        font-size: 11px;
        color: var(--text-muted);
    }
    .c-footer-bottom a { color: var(--text-muted); text-decoration: none; transition: color 0.2s; }
    .c-footer-bottom a:hover { color: var(--text-secondary); }
    .c-footer-bottom-links { display: flex; gap: 20px; }

    .c-gold-rule { width: 36px; height: 1px; background: var(--gold); opacity: 0.4; margin-bottom: 20px; }

    @media (max-width: 768px) {
        .c-footer-grid { grid-template-columns: 1fr 1fr; gap: 32px; }
        .c-footer-bottom { flex-direction: column; gap: 12px; text-align: center; }
    }
</style>

<footer class="c-footer">
    <div class="c-footer-inner">
        <div class="c-footer-grid">

            {{-- Brand column --}}
            <div>
                <div class="c-footer-brand-icon">
                    <svg viewBox="0 0 24 24"><path d="M12 2C12 2 8 6 8 10C8 14 10 16 12 18C14 16 16 14 16 10C16 6 12 2 12 2Z"/></svg>
                </div>
                <div class="c-footer-brand-name">{{ config('app.name') }}</div>
                <div class="c-gold-rule"></div>
                <p class="c-footer-tagline">{{ __('Luxury fragrances crafted from the finest ingredients around the world.') }}</p>

                <div class="c-footer-socials">
                    <a href="#" class="c-footer-social" title="Instagram">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r=".5" fill="currentColor"/></svg>
                    </a>
                    <a href="#" class="c-footer-social" title="Facebook">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                    </a>
                    <a href="#" class="c-footer-social" title="Twitter / X">
                        <svg viewBox="0 0 24 24" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                    </a>
                </div>
            </div>

            {{-- Shop column --}}
            <div>
                <div class="c-footer-col-title">{{ __('Shop') }}</div>
                <ul class="c-footer-links">
                    <li><a href="#">{{ __('New Arrivals') }}</a></li>
                    <li><a href="#">{{ __('Best Sellers') }}</a></li>
                    <li><a href="#">{{ __('Collections') }}</a></li>
                    <li><a href="#">{{ __('Gift Sets') }}</a></li>
                    <li><a href="#">{{ __('Sale') }}</a></li>
                </ul>
            </div>

            {{-- Help column --}}
            <div>
                <div class="c-footer-col-title">{{ __('Help') }}</div>
                <ul class="c-footer-links">
                    <li><a href="#">{{ __('Track Order') }}</a></li>
                    <li><a href="#">{{ __('Returns') }}</a></li>
                    <li><a href="#">{{ __('Shipping Info') }}</a></li>
                    <li><a href="#">{{ __('FAQ') }}</a></li>
                    <li><a href="#">{{ __('Contact Us') }}</a></li>
                </ul>
            </div>

            {{-- Company column --}}
            <div>
                <div class="c-footer-col-title">{{ __('Company') }}</div>
                <ul class="c-footer-links">
                    <li><a href="#">{{ __('About Us') }}</a></li>
                    <li><a href="#">{{ __('Careers') }}</a></li>
                    <li><a href="#">{{ __('Press') }}</a></li>
                    <li><a href="#">{{ __('Privacy Policy') }}</a></li>
                    <li><a href="#">{{ __('Terms of Use') }}</a></li>
                </ul>
            </div>

        </div>

        <div class="c-footer-bottom">
            <span>© {{ date('Y') }} {{ config('app.name') }}. {{ __('All rights reserved.') }}</span>
            <div class="c-footer-bottom-links">
                <a href="#">{{ __('Privacy') }}</a>
                <a href="#">{{ __('Terms') }}</a>
                <a href="#">{{ __('Cookies') }}</a>
            </div>
        </div>
    </div>
</footer>