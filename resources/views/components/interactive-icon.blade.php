@props(['size' => 'auto'])

<div {{ $attributes->merge(['class' => 'interactive-icon-wrapper']) }} style="width: {{ $size }}; height: {{ $size }};">
    <div class="interactive-icon-container">
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
    --gap-percent: 0%;
    --inner-scale: 0.85; /* Controls how much smaller the inner square is */
    
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
    background-color: black; /* Black outer square */
    transition: background-color 0.3s ease;
    aspect-ratio: 1/1;
    border: none;
    outline: none;
}

.interactive-icon-square::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: calc(100% * var(--inner-scale));
    height: calc(100% * var(--inner-scale));
    transform: translate(-50%, -50%);
    background-color: var(--inner-color, white); /* Default inner square color */
    transition: background-color 0.3s ease;
}

/* Blue squares - with selector that can be overridden */
.interactive-icon-container .interactive-icon-square.blue-square::after,
.interactive-icon-container .interactive-icon-square:nth-child(1)::after,
.interactive-icon-container .interactive-icon-square:nth-child(2)::after,
.interactive-icon-container .interactive-icon-square:nth-child(9)::after,
.interactive-icon-container .interactive-icon-square:nth-child(10)::after,
.interactive-icon-container .interactive-icon-square:nth-child(19)::after,
.interactive-icon-container .interactive-icon-square:nth-child(20)::after,
.interactive-icon-container .interactive-icon-square:nth-child(27)::after,
.interactive-icon-container .interactive-icon-square:nth-child(28)::after,
.interactive-icon-container .interactive-icon-square:nth-child(37)::after,
.interactive-icon-container .interactive-icon-square:nth-child(38)::after,
.interactive-icon-container .interactive-icon-square:nth-child(45)::after,
.interactive-icon-container .interactive-icon-square:nth-child(46)::after,
.interactive-icon-container .interactive-icon-square:nth-child(55)::after,
.interactive-icon-container .interactive-icon-square:nth-child(56)::after,
.interactive-icon-container .interactive-icon-square:nth-child(63)::after,
.interactive-icon-container .interactive-icon-square:nth-child(64)::after {
    background-color: #00bcd4;
}

/* White squares - with selector that can be overridden */
.interactive-icon-container .interactive-icon-square.white-square::after,
.interactive-icon-container .interactive-icon-square:nth-child(7)::after,
.interactive-icon-container .interactive-icon-square:nth-child(8)::after,
.interactive-icon-container .interactive-icon-square:nth-child(15)::after,
.interactive-icon-container .interactive-icon-square:nth-child(16)::after,
.interactive-icon-container .interactive-icon-square:nth-child(49)::after,
.interactive-icon-container .interactive-icon-square:nth-child(50)::after,
.interactive-icon-container .interactive-icon-square:nth-child(57)::after,
.interactive-icon-container .interactive-icon-square:nth-child(58)::after {
    background-color: white;
}

/* Override styles for hovering - this needs the highest specificity */
.interactive-icon-square[style*="--inner-color"]::after {
    background-color: var(--inner-color) !important;
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
    background-color: transparent;
    pointer-events: none;
}

.interactive-icon-container .interactive-icon-square:nth-child(3)::after,
.interactive-icon-container .interactive-icon-square:nth-child(4)::after,
.interactive-icon-container .interactive-icon-square:nth-child(5)::after,
.interactive-icon-container .interactive-icon-square:nth-child(6)::after,
.interactive-icon-container .interactive-icon-square:nth-child(11)::after,
.interactive-icon-container .interactive-icon-square:nth-child(12)::after,
.interactive-icon-container .interactive-icon-square:nth-child(13)::after,
.interactive-icon-container .interactive-icon-square:nth-child(14)::after,
.interactive-icon-container .interactive-icon-square:nth-child(17)::after,
.interactive-icon-container .interactive-icon-square:nth-child(18)::after,
.interactive-icon-container .interactive-icon-square:nth-child(23)::after,
.interactive-icon-container .interactive-icon-square:nth-child(24)::after,
.interactive-icon-container .interactive-icon-square:nth-child(25)::after,
.interactive-icon-container .interactive-icon-square:nth-child(26)::after,
.interactive-icon-container .interactive-icon-square:nth-child(31)::after,
.interactive-icon-container .interactive-icon-square:nth-child(32)::after,
.interactive-icon-container .interactive-icon-square:nth-child(33)::after,
.interactive-icon-container .interactive-icon-square:nth-child(34)::after,
.interactive-icon-container .interactive-icon-square:nth-child(39)::after,
.interactive-icon-container .interactive-icon-square:nth-child(40)::after,
.interactive-icon-container .interactive-icon-square:nth-child(41)::after,
.interactive-icon-container .interactive-icon-square:nth-child(42)::after,
.interactive-icon-container .interactive-icon-square:nth-child(47)::after,
.interactive-icon-container .interactive-icon-square:nth-child(48)::after,
.interactive-icon-container .interactive-icon-square:nth-child(51)::after,
.interactive-icon-container .interactive-icon-square:nth-child(52)::after,
.interactive-icon-container .interactive-icon-square:nth-child(53)::after,
.interactive-icon-container .interactive-icon-square:nth-child(54)::after,
.interactive-icon-container .interactive-icon-square:nth-child(59)::after,
.interactive-icon-container .interactive-icon-square:nth-child(60)::after,
.interactive-icon-container .interactive-icon-square:nth-child(61)::after,
.interactive-icon-container .interactive-icon-square:nth-child(62)::after {
    display: none;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const containers = document.querySelectorAll('.interactive-icon-container');
    
    containers.forEach(container => {
        const squares = container.querySelectorAll('.interactive-icon-square');
        const blueColor = '#00bcd4';
        const blueColorRgb = 'rgb(0, 188, 212)';
        const whiteColor = '#ffffff';
        const whiteColorRgb = 'rgb(255, 255, 255)';
        let lastChangedSquare = null;

        // Find non-blank squares (those with ::after content)
        const nonBlankSquares = Array.from(squares).filter(square => {
            // Check if the square has a visible pseudo-element
            const computedStyle = window.getComputedStyle(square, '::after');
            return computedStyle.display !== 'none';
        });

        nonBlankSquares.forEach(square => {
            square.addEventListener('mouseenter', () => {
                // Check current color of the pseudo element
                const computedStyle = window.getComputedStyle(square, '::after');
                const initialColor = computedStyle.backgroundColor;
                
                // Determine if this is a blue or white square (normalize RGB values)
                const isBlueSquare = initialColor.includes('0, 188, 212') || initialColor === blueColor || initialColor === blueColorRgb;
                
                // Set the new color for this square's pseudo element - switch colors
                const newColor = isBlueSquare ? whiteColor : blueColor;
                square.style.setProperty('--inner-color', newColor);
                
                // Find a random square with the opposite initial color
                const oppositeColorSquares = nonBlankSquares.filter(s => {
                    if (s === square) return false;
                    const style = window.getComputedStyle(s, '::after');
                    const sColor = style.backgroundColor;
                    
                    // If current square is blue, find white squares and vice versa
                    if (isBlueSquare) {
                        return sColor.includes('255, 255, 255') || sColor === whiteColor || sColor === whiteColorRgb;
                    } else {
                        return sColor.includes('0, 188, 212') || sColor === blueColor || sColor === blueColorRgb;
                    }
                });
                
                if (oppositeColorSquares.length > 0) {
                    if (lastChangedSquare) {
                        lastChangedSquare.style.removeProperty('--inner-color');
                    }
                    const randomSquare = oppositeColorSquares[Math.floor(Math.random() * oppositeColorSquares.length)];
                    randomSquare.style.setProperty('--inner-color', isBlueSquare ? blueColor : whiteColor);
                    lastChangedSquare = randomSquare;
                }
            });

            square.addEventListener('mouseleave', () => {
                square.style.removeProperty('--inner-color');
                if (lastChangedSquare) {
                    lastChangedSquare.style.removeProperty('--inner-color');
                    lastChangedSquare = null;
                }
            });
        });
    });
});
</script> 