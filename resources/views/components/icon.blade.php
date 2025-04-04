<div {{ $attributes->merge(['class' => 'custom-icon-grid']) }}>
    <!-- 8x8 Grid of squares to form our custom icon -->
    @for ($row = 0; $row < 8; $row++)
        @for ($col = 0; $col < 8; $col++)
            <div class="custom-icon-square
                @if(
                    /* Top-left 2x2 square */
                    ($row < 2 && $col < 2) ||
                    /* Bottom-right 2x2 square */
                    ($row > 5 && $col > 5) ||
                    /* Middle area */
                    (($row > 1 && $row < 4) && ($col > 4 && $col < 7)) ||
                    (($row > 4 && $row < 7) && ($col > 1 && $col < 4))
                ) custom-icon-filled @endif
                
                @if(
                    /* Transparent areas */
                    ($row > 0 && $row < 5 && $col > 1 && $col < 6 && !($row > 1 && $row < 4 && $col > 4 && $col < 7)) ||
                    ($row > 3 && $row < 8 && $col > 1 && $col < 6 && !($row > 4 && $row < 7 && $col > 1 && $col < 4))
                ) custom-icon-transparent @endif
            "></div>
        @endfor
    @endfor
</div>

<style>
.custom-icon-grid {
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    grid-template-rows: repeat(8, 1fr);
    gap: 0;
    aspect-ratio: 1 / 1;
}

.custom-icon-square {
    aspect-ratio: 1 / 1;
    box-sizing: border-box;
    border: 2px solid currentColor;
    background-color: white;
}

.custom-icon-filled {
    background-color: #00bcd4; /* Light blue color */
}

.custom-icon-transparent {
    border: none;
    background-color: transparent !important;
}
</style> 