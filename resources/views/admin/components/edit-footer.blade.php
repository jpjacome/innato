<x-control-panel-layout>
    <div class="control-panel-card control-panel-with-fixed-actions">
        <div class="control-panel-header-flex">
            <a href="{{ route('admin.pages') }}" class="control-panel-button control-panel-button-secondary">
                <i class="fas fa-arrow-left"></i> Back to Pages
            </a>
            <h2 class="control-panel-title control-panel-title-no-margin">Edit Footer Component</h2>
        </div>
        <p class="control-panel-text-muted">Edit the content and settings for your site's footer.</p>

        @if(session('success'))
            <div class="alert alert-success control-panel-alert-success-custom">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error control-panel-alert-error-custom">
                <ul class="control-panel-alert-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="footer-edit-form" method="POST" action="{{ route('admin.components.update-footer') }}" enctype="multipart/form-data" class="control-panel-form-section">
            @csrf
            @method('PUT')

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-map-marker-alt"></i> Contact Information
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="footer_address" class="control-panel-label">Address</label>
                        <input type="text" id="footer_address" name="footer_address" class="control-panel-input" value="{{ old('footer_address', $footerSetting->address ?? 'LUIS CORDERO Y REINA VICTORIA') }}" placeholder="LUIS CORDERO Y REINA VICTORIA">
                    </div>
                    <div>
                        <label for="footer_phone" class="control-panel-label">Phone Number</label>
                        <input type="text" id="footer_phone" name="footer_phone" class="control-panel-input" value="{{ old('footer_phone', $footerSetting->phone ?? '(593) 09 6710-7073') }}" placeholder="(593) 09 6710-7073">
                    </div>
                    <div>
                        <label for="footer_location" class="control-panel-label">Location</label>
                        <input type="text" id="footer_location" name="footer_location" class="control-panel-input" value="{{ old('footer_location', $footerSetting->location ?? 'QUITO - ECUADOR') }}" placeholder="QUITO - ECUADOR">
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-share-alt"></i> Social Media
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="twitter_url" class="control-panel-label">Twitter/X URL</label>
                        <input type="url" id="twitter_url" name="twitter_url" class="control-panel-input" value="{{ old('twitter_url', $footerSetting->twitter_url ?? '') }}" placeholder="https://twitter.com/youraccount">
                        <small class="control-panel-text-muted">Current icon: ph-x-logo</small>
                    </div>
                    <div>
                        <label for="instagram_url" class="control-panel-label">Instagram URL</label>
                        <input type="url" id="instagram_url" name="instagram_url" class="control-panel-input" value="{{ old('instagram_url', $footerSetting->instagram_url ?? '') }}" placeholder="https://instagram.com/youraccount">
                        <small class="control-panel-text-muted">Current icon: ph-instagram-logo</small>
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-envelope"></i> Newsletter Section
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="newsletter_title" class="control-panel-label">Newsletter Title</label>
                        <input type="text" id="newsletter_title" name="newsletter_title" class="control-panel-input" value="{{ old('newsletter_title', $footerSetting->newsletter_title ?? 'Subscribe to our newsletter') }}" placeholder="Subscribe to our newsletter">
                    </div>
                    <div>
                        <label for="newsletter_placeholder" class="control-panel-label">Email Input Placeholder</label>
                        <input type="text" id="newsletter_placeholder" name="newsletter_placeholder" class="control-panel-input" value="{{ old('newsletter_placeholder', $footerSetting->newsletter_placeholder ?? 'Your email') }}" placeholder="Your email">
                    </div>
                    <div>
                        <label for="newsletter_button_text" class="control-panel-label">Submit Button Text</label>
                        <input type="text" id="newsletter_button_text" name="newsletter_button_text" class="control-panel-input" value="{{ old('newsletter_button_text', $footerSetting->newsletter_button_text ?? 'Send') }}" placeholder="Send">
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-image"></i> Badge Image
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="footer_badge" class="control-panel-label">Badge Image</label>
                        <div style="margin-bottom: 10px;">
                            <strong>Current:</strong> {{ asset('assets/imgs/badge.png') }}
                        </div>
                        <img src="{{ asset('assets/imgs/badge.png') }}" alt="Current Badge" style="max-width:120px; margin-bottom: 10px;">
                        <input type="file" id="footer_badge" name="footer_badge" class="control-panel-input" accept="image/*">
                        <small class="control-panel-text-muted">Upload a new badge image to replace the current one</small>
                    </div>
                </div>
            </div>

            <div class="control-panel-card pages-card control-panel-form-section">
                <h3 class="control-panel-subtitle">
                    <i class="fas fa-copyright"></i> Copyright & Attribution
                </h3>
                <div class="control-panel-form-grid">
                    <div>
                        <label for="copyright_text" class="control-panel-label">Copyright Text</label>
                        <input type="text" id="copyright_text" name="copyright_text" class="control-panel-input" value="{{ old('copyright_text', $footerSetting->copyright_text ?? '© 2025 INNATO – BRANNA BRANDS.') }}" placeholder="© 2025 INNATO – BRANNA BRANDS.">
                    </div>
                    <div>
                        <label for="attribution_text" class="control-panel-label">Attribution Text</label>
                        <input type="text" id="attribution_text" name="attribution_text" class="control-panel-input" value="{{ old('attribution_text', $footerSetting->attribution_text ?? 'carefully crafted by') }}" placeholder="carefully crafted by">
                    </div>
                    <div>
                        <label for="attribution_url" class="control-panel-label">Attribution URL</label>
                        <input type="url" id="attribution_url" name="attribution_url" class="control-panel-input" value="{{ old('attribution_url', $footerSetting->attribution_url ?? 'https://drpixel.it.nf/') }}" placeholder="https://drpixel.it.nf/">
                    </div>
                    <div>
                        <label for="attribution_link_text" class="control-panel-label">Attribution Link Text</label>
                        <input type="text" id="attribution_link_text" name="attribution_link_text" class="control-panel-input" value="{{ old('attribution_link_text', $footerSetting->attribution_link_text ?? 'DR PIXEL') }}" placeholder="DR PIXEL">
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Fixed Action Buttons -->
    <div class="control-panel-fixed-actions">
        <a href="{{ route('admin.pages') }}" class="control-panel-button">
            <i class="fas fa-times"></i> Cancel
        </a>
        <button type="submit" form="footer-edit-form" class="control-panel-button">
            <i class="fas fa-save"></i> Save Changes
        </button>
        <a href="/" target="_blank" class="control-panel-button">
            <i class="fas fa-external-link-alt"></i> View Site
        </a>
    </div>
</x-control-panel-layout>
