@props(['rating' => 4, 'text', 'reviewer'])

<div class="review-card">
    <div class="stars">
        @if($rating >= 4)
            <div class="more">...</div>
        @endif
        
        @for ($i = 1; $i <= 4; $i++)
            @if ($i <= $rating)
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="28px" height="28px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 1.47 1.42" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003"> <defs>  <style type="text/css">   <![CDATA[    .fil0 {fill:#ED5934}   ]]>  </style> </defs> <g id="Layer_x0020_1"> <metadata id="CorelCorpID_0Corel-Layer"/>  <path class="fil0" d="M1.46 0.53c-0.01,-0.04 -0.05,-0.07 -0.09,-0.07l-0.39 -0.03 -0.15 -0.36c-0.01,-0.04 -0.05,-0.07 -0.1,-0.07 -0.04,0 -0.08,0.03 -0.1,0.07l-0.14 0.36 -0.39 0.03c-0.06,0 -0.1,0.05 -0.1,0.11 0,0.03 0.01,0.06 0.04,0.08l0.29 0.25 -0.09 0.38c0,0.01 0,0.02 0,0.03 0,0.06 0.05,0.11 0.11,0.11 0.02,0 0.04,-0.01 0.05,-0.02l0.33 -0.2 0.33 0.2c0.02,0.01 0.04,0.01 0.06,0.01 0.06,0 0.11,-0.04 0.11,-0.1 0,-0.01 0,-0.02 0,-0.03l-0.1 -0.38 0.3 -0.25c0.02,-0.02 0.04,-0.05 0.04,-0.08 0,-0.02 0,-0.03 -0.01,-0.04z"/> </g></svg>
            @else
                <svg xmlns="http://www.w3.org/2000/svg" xml:space="preserve" width="28px" height="28px" version="1.1" style="shape-rendering:geometricPrecision; text-rendering:geometricPrecision; image-rendering:optimizeQuality; fill-rule:evenodd; clip-rule:evenodd" viewBox="0 0 1.47 1.42" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:xodm="http://www.corel.com/coreldraw/odm/2003"> <defs>  <style type="text/css">   <![CDATA[    .fil0 {fill:#ED5934}   ]]>  </style> </defs> <g id="Layer_x0020_1"> <metadata id="CorelCorpID_0Corel-Layer"/>  <path class="fil0" d="M1.46 0.53c-0.01,-0.04 -0.05,-0.07 -0.09,-0.07l-0.39 -0.03 -0.15 -0.36c-0.01,-0.04 -0.05,-0.07 -0.1,-0.07 -0.04,0 -0.08,0.03 -0.1,0.07l-0.14 0.36 -0.39 0.03c-0.06,0 -0.1,0.05 -0.1,0.11 0,0.03 0.01,0.06 0.04,0.08l0.29 0.25 -0.09 0.38c0,0.01 0,0.02 0,0.03 0,0.06 0.05,0.11 0.11,0.11 0.02,0 0.04,-0.01 0.05,-0.02l0.33 -0.2 0.33 0.2c0.02,0.01 0.04,0.01 0.06,0.01 0.06,0 0.11,-0.04 0.11,-0.1 0,-0.01 0,-0.02 0,-0.03l-0.1 -0.38 0.3 -0.25c0.02,-0.02 0.04,-0.05 0.04,-0.08 0,-0.02 0,-0.03 -0.01,-0.04z"/> </g></svg>
            @endif
        @endfor
    </div>
    <p class="review-text">"{{ $text }}"</p>
    <p class="reviewer-name">- {{ $reviewer }}</p>
</div>
