@php
    $footerSetting = \App\Models\FooterSetting::instance();
@endphp

<!-- Footer -->
<footer>
    <div class="wrapper-1 fade-in-1">
        <div class="container container-1">
            <div class="footer-address">{{ $footerSetting->address }}</div>
            <div class="footer-phone">{{ $footerSetting->phone }}</div>
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
            <form class="footer-newsletter-form" autocomplete="off">
                <input type="email" class="footer-newsletter-input" placeholder="{{ $footerSetting->newsletter_placeholder }}" required />
                <button type="submit" class="footer-newsletter-btn">{{ $footerSetting->newsletter_button_text }}</button>
            </form>
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
