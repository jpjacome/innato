@props(['size' => 'auto', 'borderScale' => '0.1'])

<div {{ $attributes->merge(['class' => 'interactive-icon-wrapper']) }} style="width: {{ $size }}; height: {{ $size }};">
    <div class="interactive-icon-container" style="--border-scale: {{ $borderScale }}">
        <!-- Creating an 8x8 grid -->
        @for ($i = 1; $i <= 64; $i++)
            <div class="interactive-icon-square"></div>
        @endfor
    </div>
</div>

<style>
.interactive-icon-wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
}

.interactive-icon-container {
    --grid-size: 8;
    --gap-percent: 3%;
    --square-size: calc(100% / var(--grid-size));
    --border-width: calc(var(--square-size) * var(--border-scale, 0.1));
    
    display: grid;
    grid-template-columns: repeat(8, 1fr);
    grid-template-rows: repeat(8, 1fr);
    gap: var(--gap-percent);
    width: 100%;
    height: 100%;
    aspect-ratio: 1/1;
    box-sizing: border-box;
    position: relative;
}

.interactive-icon-square {
    width: 100%;
    height: 100%;
    box-sizing: border-box;
    position: relative;
    background-color: white;
    transition: background-color 0.3s ease;
    aspect-ratio: 1/1;
    border: calc(var(--border-width)) solid currentColor;
}

.interactive-icon-filled {
    background-color: #00bcd4; /* Light blue color */
}

/* Blank squares */
.interactive-icon-container .interactive-icon-square:nth-child(3),
.interactive-icon-container .interactive-icon-square:nth-child(4),
.interactive-icon-container .interactive-icon-square:nth-child(5),
.interactive-icon-container .interactive-icon-square:nth-child(6),
.interactive-icon-container .interactive-icon-square:nth-child(11),
.interactive-icon-container .interactive-icon-square:nth-child(12),
.interactive-icon-container .interactive-icon-square:nth-child(13),
.interactive-icon-container .interactive-icon-square:nth-child(14),
.interactive-icon-container .interactive-icon-square:nth-child(17),
.interactive-icon-container .interactive-icon-square:nth-child(18),
.interactive-icon-container .interactive-icon-square:nth-child(23),
.interactive-icon-container .interactive-icon-square:nth-child(24),
.interactive-icon-container .interactive-icon-square:nth-child(25),
.interactive-icon-container .interactive-icon-square:nth-child(26),
.interactive-icon-container .interactive-icon-square:nth-child(31),
.interactive-icon-container .interactive-icon-square:nth-child(32),
.interactive-icon-container .interactive-icon-square:nth-child(33),
.interactive-icon-container .interactive-icon-square:nth-child(34),
.interactive-icon-container .interactive-icon-square:nth-child(39),
.interactive-icon-container .interactive-icon-square:nth-child(40),
.interactive-icon-container .interactive-icon-square:nth-child(41),
.interactive-icon-container .interactive-icon-square:nth-child(42),
.interactive-icon-container .interactive-icon-square:nth-child(47),
.interactive-icon-container .interactive-icon-square:nth-child(48),
.interactive-icon-container .interactive-icon-square:nth-child(51),
.interactive-icon-container .interactive-icon-square:nth-child(52),
.interactive-icon-container .interactive-icon-square:nth-child(53),
.interactive-icon-container .interactive-icon-square:nth-child(54),
.interactive-icon-container .interactive-icon-square:nth-child(59),
.interactive-icon-container .interactive-icon-square:nth-child(60),
.interactive-icon-container .interactive-icon-square:nth-child(61),
.interactive-icon-container .interactive-icon-square:nth-child(62) {
    border: none;
    pointer-events: none;
    background-color: transparent !important;
}

/* Blank squares 2 */
.interactive-icon-container .interactive-icon-square:nth-child(3),
.interactive-icon-container .interactive-icon-square:nth-child(11),
.interactive-icon-container .interactive-icon-square:nth-child(23),
.interactive-icon-container .interactive-icon-square:nth-child(31),
.interactive-icon-container .interactive-icon-square:nth-child(39),
.interactive-icon-container .interactive-icon-square:nth-child(47),
.interactive-icon-container .interactive-icon-square:nth-child(51),
.interactive-icon-container .interactive-icon-square:nth-child(59) {
    border-left: calc(var(--border-width)) solid currentColor;
}

/* Blank squares 3 */
.interactive-icon-container .interactive-icon-square:nth-child(17),
.interactive-icon-container .interactive-icon-square:nth-child(18),
.interactive-icon-container .interactive-icon-square:nth-child(23),
.interactive-icon-container .interactive-icon-square:nth-child(24),
.interactive-icon-container .interactive-icon-square:nth-child(51),
.interactive-icon-container .interactive-icon-square:nth-child(52),
.interactive-icon-container .interactive-icon-square:nth-child(53),
.interactive-icon-container .interactive-icon-square:nth-child(54) {
    border-top: calc(var(--border-width)) solid currentColor;
}

/* Top-left 2x2 square */
.interactive-icon-container .interactive-icon-square:nth-child(1),
.interactive-icon-container .interactive-icon-square:nth-child(2),
.interactive-icon-container .interactive-icon-square:nth-child(9),
.interactive-icon-container .interactive-icon-square:nth-child(10) {
    background-color: #00bcd4;
}

/* Top-right 2x2 square */
.interactive-icon-container .interactive-icon-square:nth-child(7),
.interactive-icon-container .interactive-icon-square:nth-child(8),
.interactive-icon-container .interactive-icon-square:nth-child(15),
.interactive-icon-container .interactive-icon-square:nth-child(16) {
    background-color: white;
}

/* Bottom-left 2x2 square */
.interactive-icon-container .interactive-icon-square:nth-child(49),
.interactive-icon-container .interactive-icon-square:nth-child(50),
.interactive-icon-container .interactive-icon-square:nth-child(57),
.interactive-icon-container .interactive-icon-square:nth-child(58) {
    background-color: white;
}

/* Bottom-right 2x2 square */
.interactive-icon-container .interactive-icon-square:nth-child(55),
.interactive-icon-container .interactive-icon-square:nth-child(56),
.interactive-icon-container .interactive-icon-square:nth-child(63),
.interactive-icon-container .interactive-icon-square:nth-child(64) {
    background-color: #00bcd4;
}

/* Middle squares */
.interactive-icon-container .interactive-icon-square:nth-child(19),
.interactive-icon-container .interactive-icon-square:nth-child(20),
.interactive-icon-container .interactive-icon-square:nth-child(27),
.interactive-icon-container .interactive-icon-square:nth-child(28),
.interactive-icon-container .interactive-icon-square:nth-child(37),
.interactive-icon-container .interactive-icon-square:nth-child(38),
.interactive-icon-container .interactive-icon-square:nth-child(45),
.interactive-icon-container .interactive-icon-square:nth-child(46) {
    background-color: #00bcd4;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.interactive-icon-container');
    
    containers.forEach(container => {
        const squares = container.querySelectorAll('.interactive-icon-square');
        const blueColor = '#00bcd4';
        const whiteColor = 'rgb(255, 255, 255)';
        let lastChangedSquare = null;

        // Store the original colors and identify non-blank squares
        const nonBlankSquares = Array.from(squares).filter(square => {
            const computedStyle = window.getComputedStyle(square);
            const backgroundColor = computedStyle.backgroundColor;
            square.originalColor = backgroundColor;
            return backgroundColor !== 'rgba(0, 0, 0, 0)' && backgroundColor !== 'transparent';
        });

        nonBlankSquares.forEach(square => {
            square.addEventListener('mouseenter', () => {
                const initialColor = square.originalColor;
                const newColor = initialColor === 'rgb(0, 188, 212)' ? whiteColor : blueColor;
                square.style.backgroundColor = newColor;

                // Find a random square with the opposite initial color
                const oppositeColorSquares = nonBlankSquares.filter(s => 
                    s.originalColor === (initialColor === 'rgb(0, 188, 212)' ? whiteColor : 'rgb(0, 188, 212)') &&
                    s !== square
                );
                
                if (oppositeColorSquares.length > 0) {
                    if (lastChangedSquare) {
                        lastChangedSquare.style.backgroundColor = lastChangedSquare.originalColor;
                    }
                    const randomSquare = oppositeColorSquares[Math.floor(Math.random() * oppositeColorSquares.length)];
                    randomSquare.style.backgroundColor = initialColor;
                    lastChangedSquare = randomSquare;
                }
            });

            square.addEventListener('mouseleave', () => {
                square.style.backgroundColor = square.originalColor;
                if (lastChangedSquare) {
                    lastChangedSquare.style.backgroundColor = lastChangedSquare.originalColor;
                    lastChangedSquare = null;
                }
            });
        });
    });
});
</script> 