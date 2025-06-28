<!-- Header Component -->
<header class='fade-in-1'>
    <div class="logo fade-in-1">
        <a href="/home"><img src="{{ asset('assets/imgs/logo.svg') }}" alt="logo-image"></a>
    </div>
    <nav class="main-nav fade-in-2">
        <ul class="nav-list">
            <li><a href="/about"><span class="nav-icon ph ph-users-three"></span><span class="nav-text">About Us</span></a></li>
            <li><a href="/destinations"><span class="nav-icon ph ph-path"></span><span class="nav-text">Destinations</span></a></li>
            <li><a href="/experience-center"><span class="nav-icon ph ph-buildings"></span><span class="nav-text">Tourist Experience Center</span></a></li>
            <li><a href="/hostal"><span class="nav-icon ph ph-house-simple"></span><span class="nav-text">Hostal</span></a></li>
            <li><a href="/contact"><span class="nav-icon ph ph-envelope-simple"></span><span class="nav-text">Contact</span></a></li>
            <li><a href="/reviews"><span class="nav-icon ph ph-star"></span><span class="nav-text">Reviews</span></a></li>
        </ul>
        <i id="search-toggle" class="ph ph-magnifying-glass"></i>
        <i id="hamburger-toggle" class="ph ph-list hamburger-icon"></i>
    </nav>
</header>

<div id="search-bar-container" class="search-bar-container fade-in-1">
    <input type="text" placeholder="Search..." class="search-bar-input" />
</div>

<!-- Mobile Menu -->
<div id="mobile-menu" class="mobile-menu">
    <ul>
        <li><a href="/about">About Us</a></li>
        <li><a href="/destinations">Destinations</a></li>
        <li><a href="/experience-center">Tourist Experience Center</a></li>
        <li><a href="/hostal">Hostal</a></li>
        <li><a href="/contact">Contact</a></li>
        <li><a href="/reviews">Reviews</a></li>
    </ul>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchToggle = document.getElementById('search-toggle');
        const searchBar = document.getElementById('search-bar-container');
        let searchOpen = false;
        if (searchToggle && searchBar) {
            searchToggle.addEventListener('click', function() {
                searchOpen = !searchOpen;
                if (searchOpen) {
                    searchBar.classList.add('show');
                    setTimeout(() => { searchBar.querySelector('input').focus(); }, 350);
                } else {
                    searchBar.classList.remove('show');
                }
            });
        }

        // Hamburger menu logic
        const hamburger = document.getElementById('hamburger-toggle');
        const mobileMenu = document.getElementById('mobile-menu');
        let menuOpen = false;
        if (hamburger && mobileMenu) {
            hamburger.addEventListener('click', function() {
                menuOpen = !menuOpen;
                if (menuOpen) {
                    mobileMenu.classList.add('show');
                    hamburger.classList.remove('ph-list');
                    hamburger.classList.add('ph-x-circle');
                } else {
                    mobileMenu.classList.remove('show');
                    hamburger.classList.remove('ph-x-circle');
                    hamburger.classList.add('ph-list');
                }
            });
            mobileMenu.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', () => {
                    mobileMenu.classList.remove('show');
                    hamburger.classList.remove('ph-x-circle');
                    hamburger.classList.add('ph-list');
                    menuOpen = false;
                });
            });
        }
    });
</script>
@endpush
