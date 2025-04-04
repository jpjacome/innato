<div {{ $attributes->merge(['class' => 'icon-grid']) }}>
    <!-- 8x8 Grid of squares to form our custom icon -->
    @for ($row = 0; $row < 8; $row++)
        @for ($col = 0; $col < 8; $col++)
            <div class="icon-square
                @if(
                    /* Top-left 2x2 square */
                    ($row < 2 && $col < 2) ||
                    /* Bottom-right 2x2 square */
                    ($row > 5 && $col > 5) ||
                    /* Middle area */
                    (($row > 1 && $row < 4) && ($col > 4 && $col < 7)) ||
                    (($row > 4 && $row < 7) && ($col > 1 && $col < 4))
                ) filled @endif
                
                @if(
                    /* Transparent areas */
                    ($row > 0 && $row < 5 && $col > 1 && $col < 6 && !($row > 1 && $row < 4 && $col > 4 && $col < 7)) ||
                    ($row > 3 && $row < 8 && $col > 1 && $col < 6 && !($row > 4 && $row < 7 && $col > 1 && $col < 4))
                ) transparent @endif
            "></div>
        @endfor
    @endfor
</div>

<style>
body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100%;
        }
        .container {
            display: grid;
            grid-template-columns: repeat(8, 3vw);
            grid-template-rows: repeat(8, 3vw);
            gap: .75vw;
            width: fit-content;
            height: fit-content;
        }

        .square {
            width: 3vw;
            height: 3vw;
            border: .75vw solid black;
            background-color: white;
            transition: background-color 0.3s ease;
        }

        .filled {
            background-color: #00bcd4; /* Light blue color */
        }

        /* Blank squares */
        .square:nth-child(3),
        .square:nth-child(4),
        .square:nth-child(5),
        .square:nth-child(6),
        .square:nth-child(11),
        .square:nth-child(12),
        .square:nth-child(13),
        .square:nth-child(14),
        .square:nth-child(17),
        .square:nth-child(18),
        .square:nth-child(23),
        .square:nth-child(24),
        .square:nth-child(25),
        .square:nth-child(26),
        .square:nth-child(31),
        .square:nth-child(32),
        .square:nth-child(33),
        .square:nth-child(34),
        .square:nth-child(39),
        .square:nth-child(40),
        .square:nth-child(41),
        .square:nth-child(42),
        .square:nth-child(47),
        .square:nth-child(48),
        .square:nth-child(51),
        .square:nth-child(52),
        .square:nth-child(53),
        .square:nth-child(54),
        .square:nth-child(59),
        .square:nth-child(60),
        .square:nth-child(61),
        .square:nth-child(62) {
            border: none;
            pointer-events: none;
            background-color: transparent !important;
        }
        /* Blank squares 2 */
        .square:nth-child(3),
        .square:nth-child(11),
        .square:nth-child(23),
        .square:nth-child(31),
        .square:nth-child(39),
        .square:nth-child(47),
        .square:nth-child(51),
        .square:nth-child(59) {
            border-left: .75vw solid black;
        }
        /* Blank squares 3 */
        .square:nth-child(17),
        .square:nth-child(18),
        .square:nth-child(23),
        .square:nth-child(24),
        .square:nth-child(51),
        .square:nth-child(52),
        .square:nth-child(53),
        .square:nth-child(54) {
            border-top: .75vw solid black;
        }

        /* Top-left 2x2 square */
        .square:nth-child(1),
        .square:nth-child(2),
        .square:nth-child(9),
        .square:nth-child(10) {
            background-color: #00bcd4;
        }

        /* Top-right 2x2 square */
        .square:nth-child(7),
        .square:nth-child(8),
        .square:nth-child(15),
        .square:nth-child(16) {
            background-color: white;
        }

        /* Bottom-left 2x2 square */
        .square:nth-child(49),
        .square:nth-child(50),
        .square:nth-child(57),
        .square:nth-child(58),
        .square:nth-child(65),
        .square:nth-child(66) {
            background-color: white;
        }

        /* Bottom-right 2x2 square */
        .square:nth-child(55),
        .square:nth-child(56),
        .square:nth-child(63),
        .square:nth-child(64),
        .square:nth-child(71),
        .square:nth-child(72) {
            background-color: #00bcd4;
        }

        /* Middle 4x4 square 1 */
        .square:nth-child(19),
        .square:nth-child(20),
        .square:nth-child(27),
        .square:nth-child(28),
        .square:nth-child(37),
        .square:nth-child(38),
        .square:nth-child(45),
        .square:nth-child(46) {
            background-color: #00bcd4;
        }
</style>
