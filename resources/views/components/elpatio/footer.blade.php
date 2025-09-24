<footer>
    <div class="footer-wrapper fadein-1">
      <div class="footer-logo"></div>
      @php $footer = \App\Models\ElPatioSetting::instance()->footer ?? []; $fcontact = $footer ?? []; $fsocial = $footer['social_links'] ?? []; @endphp
      <div class="footer-column about fadein-2">
          <p>{{ $footer['address'] ?? 'Luis Corder E5-58 y Reina Victoria' }}</p>
          <p>{{ $footer['city_line'] ?? 'Quito - Ecuador, EC170143' }}</p>
          <p><a href="mailto:{{ $footer['email'] ?? 'info@elpatiohostels.com' }}">{{ $footer['email'] ?? 'info@elpatiohostels.com' }}</a></p>
      </div>
    <div class="footer-column contact fadein-2">
    @php
      $phonesRaw = $footer['phones'] ?? null;
      if (is_string($phonesRaw) && trim($phonesRaw) !== '') {
        // split on newlines or commas if saved as single string
        $phones = preg_split('/[\r\n,]+/', $phonesRaw);
      } elseif (is_array($phonesRaw)) {
        $phones = $phonesRaw;
      } else {
        $phones = ['+(593) 2 2526 342','+(593) 992748998','+(593) 991448525'];
      }
      $phones = array_values(array_filter(array_map('trim', (array)$phones)));
    @endphp

    @if(count($phones))
      <p>Telephone: {{ $phones[0] ?? '' }}</p>
      @for($i = 1; $i < count($phones); $i++)
        <p>WhatsApp: {{ $phones[$i] }}</p>
      @endfor
    @else
      <p>Telephone: +(593) 2 2526 342</p>
      <p>WhatsApp: +(593) 992748998</p>
      <p>WhatsApp: +(593) 991448525</p>
    @endif
    </div>
        <div class="social-media fadein-3">
            <a href="{{ $fsocial['instagram'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-instagram.svg" alt="Instagram"></a>
            <a href="{{ $fsocial['tiktok'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-tiktok.svg" alt="TikTok"></a>
            <a href="{{ $fsocial['facebook'] ?? '' }}"><img class="social-media-icon" src="/assets/elpatio/imgs/icon-facebook.svg" alt="Facebook"></a>
        </div>
    </div>
    <div class="footer-bottom">
  <p>&copy; 2025 El Patio Hostel - Ecuador. All rights reserved.</p>
      <p class="made-by">Carefully crafted by <a href="http://drpixel.it.nf" target="_blank">Dr. Pixel</a></p>
    </div>
</footer>
