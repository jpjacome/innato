// Hero section image slideshow
document.addEventListener('DOMContentLoaded', function () {
  const heroImg = document.querySelector('.hero-section .background img');
  if (!heroImg) return;
  const heroImages = [
    './assets/imgs/photo14.webp',
    './assets/imgs/photo6.jpg',
    './assets/imgs/photo2.avif'
  ];
  let idx = 0;
  setInterval(() => {
    idx = (idx + 1) % heroImages.length;
    heroImg.style.opacity = 0;
    setTimeout(() => {
      heroImg.src = heroImages[idx];
      heroImg.style.opacity = 1;
    }, 2000);
  }, 10000);
});
// Hide loading screen on page load with slide up and fade out
document.addEventListener('DOMContentLoaded', function () {
  const loading = document.querySelector('.loading-screen');
  if (loading) {
    setTimeout(() => {
      loading.classList.remove('slide-down-in');
      loading.classList.add('fadeout-1');
      // Optionally hide after fadeout
      setTimeout(() => {
        loading.style.display = 'none';
        loading.style.transform = '';
      }, 500);
    }, 600); // Let any initial animation finish before fading out
  }
});
// Intercept external header nav and social links to show loading screen before navigating
document.addEventListener('DOMContentLoaded', function () {
  // Helper: is external link (not # and not empty)
  function isExternalLink(a) {
    const href = a.getAttribute('href');
    return href && !href.startsWith('#') && href !== '' && href !== null && href !== undefined;
  }
  // Select header nav and social links
  const header = document.querySelector('header');
  if (header) {
    // All nav links
    const navLinks = header.querySelectorAll('.nav .menu-item');
    // All social media links in header
    const socialLinks = header.querySelectorAll('.social-media a');
    // WhatsApp icon link
    const whatsappLink = header.querySelector('.whatsapp-icon');
    // Combine all
    const allLinks = [...navLinks, ...socialLinks];
    if (whatsappLink) allLinks.push(whatsappLink);
    allLinks.forEach(link => {
      if (isExternalLink(link)) {
        link.addEventListener('click', function (e) {
          e.preventDefault();
          const href = link.getAttribute('href');
          // Show loading screen: remove fade-out, add fade-in
          const loading = document.querySelector('.loading-screen');
          if (loading) {
            loading.style.display = 'flex'; // Reset display in case it was hidden
            loading.classList.remove('fadeout-1', 'fade-out-1', 'fadein-1', 'slide-down-in');
            loading.style.transform = 'translateY(0)'; // Reset position
            // Force reflow to restart animation if needed
            void loading.offsetWidth;
            loading.classList.add('slide-down-in');
            loading.style.opacity = '1';
            loading.style.pointerEvents = 'auto';
          }
          setTimeout(() => {
            window.location.href = href;
          }, 2000);
        });
      }
    });
  }
});
// Intersection Observer for fade-in effects
document.addEventListener('DOMContentLoaded', function () {
	function setupFadeObserver(fadeinClass, fadeClass) {
		const fadeEls = document.querySelectorAll('.' + fadeinClass);
		if (!('IntersectionObserver' in window)) {
			fadeEls.forEach(el => el.classList.add(fadeClass));
			return;
		}
		const observer = new IntersectionObserver((entries, observer) => {
			entries.forEach(entry => {
				if (entry.isIntersecting) {
					entry.target.classList.add(fadeClass);
					observer.unobserve(entry.target);
				}
			});
		}, {
			threshold: 0.2
		});
		fadeEls.forEach(el => observer.observe(el));
	}

  // If we're on the single blog post page, don't wait for intersection/scroll
  // — immediately add the classes so animations run on load.
  const isSinglePost = document.querySelector('.single-blog-post') !== null;
  function applyFadeClassesImmediately() {
    const mapping = {
      'fadein-1': 'fade-in-1',
      'fadein-2': 'fade-in-2',
      'fadein-3': 'fade-in-3',
      'fadein-4': 'fade-in-4',
      'fadeout-1': 'fade-out-1'
    };
    Object.keys(mapping).forEach(key => {
      const nodes = document.querySelectorAll('.' + key);
      nodes.forEach(n => n.classList.add(mapping[key]));
    });
  }

  if (isSinglePost) {
    applyFadeClassesImmediately();
  } else {
    setupFadeObserver('fadein-1', 'fade-in-1');
    setupFadeObserver('fadein-2', 'fade-in-2');
    setupFadeObserver('fadein-3', 'fade-in-3');
    setupFadeObserver('fadein-4', 'fade-in-4');
    setupFadeObserver('fadeout-1', 'fade-out-1');
  }



// Parallax effect for SVG circle windows (multiple)
function setupParallaxCircle(circleId, svgId, parallaxStrength) {
	const circle = document.getElementById(circleId);
	const svg = document.getElementById(svgId);
	if (circle && svg) {
		const initialCy = parseFloat(circle.getAttribute('cy'));
		window.addEventListener('scroll', function () {
			const rect = svg.getBoundingClientRect();
			if (rect.bottom > 0 && rect.top < window.innerHeight) {
				const scrollY = window.scrollY || window.pageYOffset;
				const offset = scrollY * parallaxStrength;
				circle.setAttribute('cy', initialCy + offset);
			}
		});
	}
}
setupParallaxCircle('parallax-circle', 'parallax-svg', -0.15);
setupParallaxCircle('parallax-circle-2', 'parallax-svg-2', -0.1);
});


document.addEventListener('DOMContentLoaded', function () {
  const cards = document.querySelectorAll('.blog-card');
  cards.forEach((card, i) => {
    const svg = card.querySelector('.blog-card-mask');
    if (!svg) return;
    const circle = svg.querySelector('circle');
    if (!circle) return;
    const initialR = parseFloat(circle.getAttribute('r'));
    const targetR = 260; // expanded radius
    let animFrame;
    let toggled = false;

    function animateR(to) {
      cancelAnimationFrame(animFrame);
      const from = parseFloat(circle.getAttribute('r'));
      const duration = 1500;
      const start = performance.now();
      function frame(now) {
        const t = Math.min((now - start) / duration, 1);
        const eased = t < 0.5 ? 2*t*t : -1+(4-2*t)*t; // easeInOut
        const r = from + (to - from) * eased;
        circle.setAttribute('r', r);
        if (t < 1) animFrame = requestAnimationFrame(frame);
        else circle.setAttribute('r', to);
      }
      animFrame = requestAnimationFrame(frame);
    }

    // Desktop hover
    card.addEventListener('mouseenter', () => {
      if (!('ontouchstart' in window)) animateR(targetR);
    });
    card.addEventListener('mouseleave', () => {
      if (!('ontouchstart' in window)) animateR(initialR);
    });

    // Touch toggle for mobile
    card.addEventListener('touchstart', function(e) {
      e.preventDefault();
      toggled = !toggled;
      animateR(toggled ? targetR : initialR);
    });
  });
});

// Animate SVG mask circle radius on single blog post image hover (attach to .blog-card-img-masked)
document.addEventListener('DOMContentLoaded', function () {
  const singlePost = document.querySelector('.single-blog-post');
  if (!singlePost) return;
  const imgMasked = singlePost.querySelector('.blog-card-img-masked');
  const svg = singlePost.querySelector('.blog-card-mask');
  if (!imgMasked || !svg) return;
  const circle = svg.querySelector('#blog-single-mask-circle');
  if (!circle) return;
  const initialR = 300;
  const targetR = 500;
  let animFrame;
  let toggled = false;

  function animateR(to) {
    cancelAnimationFrame(animFrame);
    const from = parseFloat(circle.getAttribute('r'));
    const duration = 1500;
    const start = performance.now();
    function frame(now) {
      const t = Math.min((now - start) / duration, 1);
      const eased = t < 0.5 ? 2*t*t : -1+(4-2*t)*t;
      const r = from + (to - from) * eased;
      circle.setAttribute('r', r);
      if (t < 1) animFrame = requestAnimationFrame(frame);
      else circle.setAttribute('r', to);
    }
    animFrame = requestAnimationFrame(frame);
  }

  // Desktop hover
  imgMasked.addEventListener('mouseenter', () => {
    if (!('ontouchstart' in window)) animateR(targetR);
  });
  imgMasked.addEventListener('mouseleave', () => {
    if (!('ontouchstart' in window)) animateR(initialR);
  });

  // Touch toggle for mobile
  imgMasked.addEventListener('touchstart', function(e) {
    e.preventDefault();
    toggled = !toggled;
    animateR(toggled ? targetR : initialR);
  });
});




// Swiper.js initialization for photo gallery
// Images for the gallery
const galleryImages = [
  './assets/imgs/photo1.avif',
  './assets/imgs/photo2.avif',
  './assets/imgs/photo3.jpg',
  './assets/imgs/photo4.jpg',
  './assets/imgs/photo5.jpg',
  './assets/imgs/photo6.jpg',
  './assets/imgs/photo7.jpg',
  './assets/imgs/photo8.jpg',
  './assets/imgs/photo9.jpg',
  './assets/imgs/photo10.webp',
  './assets/imgs/photo11.webp',
  './assets/imgs/photo12.webp',
  './assets/imgs/photo13.webp',
  './assets/imgs/photo14.webp',
  './assets/imgs/photo15.webp',
  './assets/imgs/photo16.png'
];

function createGallerySlides() {
  const mainWrapper = document.querySelector('.swiper-wrapper.main');
  const thumbsWrapper = document.querySelector('.swiper-wrapper.thumbs');
  if (!mainWrapper || !thumbsWrapper) return;
  mainWrapper.innerHTML = '';
  thumbsWrapper.innerHTML = '';
  galleryImages.forEach((src, i) => {
    const slide = document.createElement('div');
    slide.className = 'swiper-slide';
    // Create zoom container
    const zoomContainer = document.createElement('div');
    zoomContainer.className = 'swiper-zoom-container';
    const img = document.createElement('img');
    img.src = src;
    img.alt = `Gallery image ${i+1}`;
    img.className = 'gallery-main-img';
    zoomContainer.appendChild(img);
    slide.appendChild(zoomContainer);
    mainWrapper.appendChild(slide);

    const thumb = document.createElement('div');
    thumb.className = 'swiper-slide';
    const thumbImg = document.createElement('img');
    thumbImg.src = src;
    thumbImg.alt = `Thumbnail ${i+1}`;
    thumbImg.className = 'gallery-thumb-img';
    thumb.appendChild(thumbImg);
    thumbsWrapper.appendChild(thumb);
  });
}

document.addEventListener('DOMContentLoaded', function () {
  createGallerySlides();

  const thumbsSwiper = new Swiper('.swiper-thumbs', {
    spaceBetween: 10,
    slidesPerView: 6,
    freeMode: true,
    watchSlidesProgress: true,
    breakpoints: {
      0: { slidesPerView: 3 },
      600: { slidesPerView: 5 },
      900: { slidesPerView: 7 }
    }
  });

  const mainSwiper = new Swiper('.swiper-main', {
    spaceBetween: 10,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
    },
    thumbs: {
      swiper: thumbsSwiper
    },
    loop: true
    // No zoom, no click handler for zoom
  });
});


// Animate SVG mask circle radius on about section image hover
function setupAboutCircleHover(circleId, svgId, initialR, targetR, duration) {
  const svg = document.getElementById(svgId);
  const circle = document.getElementById(circleId);
  if (!svg || !circle) return;
  let animFrame;
  function animateR(to) {
    cancelAnimationFrame(animFrame);
    const from = parseFloat(circle.getAttribute('r'));
    const start = performance.now();
    function frame(now) {
      const t = Math.min((now - start) / duration, 1);
      const eased = t < 0.5 ? 2*t*t : -1+(4-2*t)*t;
      const r = from + (to - from) * eased;
      circle.setAttribute('r', r);
      if (t < 1) animFrame = requestAnimationFrame(frame);
      else circle.setAttribute('r', to);
    }
    animFrame = requestAnimationFrame(frame);
  }
  svg.addEventListener('mouseenter', () => animateR(targetR));
  svg.addEventListener('mouseleave', () => animateR(initialR));
}
setupAboutCircleHover('parallax-circle', 'parallax-svg', 210, 400, 2000);
setupAboutCircleHover('parallax-circle-2', 'parallax-svg-2', 140, 400, 2000);


// Parallax effect for hero section background image
function setupHeroParallax() {
  const bg = document.querySelector('.hero-section .background img');
  if (!bg) return;
  window.addEventListener('scroll', function () {
    const scrolled = window.scrollY || window.pageYOffset;
    // Move the image up to 40px as you scroll 0-400px
    const translateY = Math.min(scrolled * 0.3, 130);
    bg.style.transform = `translateY(${translateY}px)`;
  });
}
document.addEventListener('DOMContentLoaded', setupHeroParallax);


