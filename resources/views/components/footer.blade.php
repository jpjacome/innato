@php
    $footerSetting = \App\Models\FooterSetting::instance();
@endphp

<!-- Footer -->
<footer>
    <div class="wrapper-1 fade-in-1">
        <div class="container container-1">
            <div class="footer-address">{{ $footerSetting->address }}</div>
            <div class="footer-phone">{{ $footerSetting->phone }}</div>
            <div class="footer-email">{{ $footerSetting->email }}</div>
            <div class="footer-location">{{ $footerSetting->location }}</div>
            <div class="footer-socials">
                @if($footerSetting->twitter_url)
                    <a href="{{ $footerSetting->twitter_url }}" target="_blank"><i class="ph ph-x-logo"></i></a>
                @else
                    <i class="ph ph-x-logo"></i>
                @endif
                @if($footerSetting->instagram_url)
                    <a href="{{ $footerSetting->instagram_url }}" target="_blank"><i class="ph ph-instagram-logo"></i></a>
                @else
                    <i class="ph ph-instagram-logo"></i>
                @endif
            </div>
        </div>
        <div class="container" id="container-2">
            <h3 class="footer-newsletter-title">{{ $footerSetting->newsletter_title }}</h3>
            <form x-data="{ sending: false }" @submit="sending = true" class="footer-newsletter-form" method="POST" action="{{ route('newsletter.subscribe') }}" autocomplete="off">
                @csrf
                <!-- Honeypot field for spam bots -->
                <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
                <input type="email" name="email" class="footer-newsletter-input" placeholder="{{ $footerSetting->newsletter_placeholder }}" required />
                <button type="submit" class="footer-newsletter-btn" x-text="sending ? 'Sending...' : '{{ $footerSetting->newsletter_button_text }}'" :disabled="sending"></button>
            </form>
            <!-- Newsletter confirmation/error modal -->
            <div x-data="{ show: {{ session('success') || session('error') ? 'true' : 'false' }} }" x-show="show" @click.away="show = false" style="display: none;" class="newsletter-modal">
                <div class="newsletter-modal-content">
                    <span x-text="'{{ session('success') ?? session('error') }}'"></span>
                    <button @click="show = false" class="newsletter-modal-close">Close</button>
                </div>
            </div>
        </div>
        <div class="container container-3">
            <img src="/assets/imgs/badge.png" alt="">
        </div>
    </div>
    <div class="footer-copyright">{{ $footerSetting->copyright_text }}</div>
</footer>
<div class="drpixel fade-in-1">
    <x-interactive-icon size="20px" />{{ $footerSetting->attribution_text }} <a href="{{ $footerSetting->attribution_url }}">{{ $footerSetting->attribution_link_text }}</a>
</div>