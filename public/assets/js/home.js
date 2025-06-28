document.addEventListener('DOMContentLoaded', function () {  // Function to handle fade animations
  function setupFadeAnimation(triggerClass, animationClass, threshold = 0.1) {
    const fadeElements = Array.from(document.getElementsByClassName(triggerClass));

    // Create Intersection Observer
    const observer = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          // Add the animation class to trigger the CSS animation immediately
          entry.target.classList.add(animationClass);
          obs.unobserve(entry.target);
        }
      });
    }, { threshold: threshold });

    // Observe all elements with the trigger class
    fadeElements.forEach((el) => {
      observer.observe(el);
    });
  }  // Setup fade animations for different classes
  setupFadeAnimation('fade-in-1', 'fade-1', 0.1);  // fade-in-1 -> fade-1, no delay
  setupFadeAnimation('fade-in-2', 'fade-2', 0.1);  // fade-in-2 -> fade-2, CSS handles delay
  setupFadeAnimation('fade-in-3', 'fade-3', 0.1);  // fade-in-3 -> fade-3
  setupFadeAnimation('fade-img', 'fade-img', 0.1);  // fade-img -> fade-img



  // Parallax effect for multiple classes with different speeds
  function setupParallax() {
    const parallaxElements = [
      { selector: '.parallax', speed: -0.4 },
      { selector: '.parallax-2', speed: 0.2 }
    ];

    const elements = [];
    
    // Find all parallax elements
    parallaxElements.forEach(config => {
      const els = document.querySelectorAll(config.selector);
      els.forEach(el => {
        elements.push({
          element: el,
          speed: config.speed
        });
      });
    });

    if (elements.length === 0) return;

    function updateParallax() {
      const scrolled = window.pageYOffset;
      const windowHeight = window.innerHeight;
      
      elements.forEach(item => {
        const { element, speed } = item;
        const sectionTop = element.offsetTop;
        const sectionHeight = element.offsetHeight;
        
        // Check if section is in viewport
        if (scrolled + windowHeight > sectionTop && scrolled < sectionTop + sectionHeight) {
          // Calculate parallax offset
          const yPos = -(scrolled - sectionTop) * speed;
          
          // Apply transform
          element.style.transform = `translateY(${yPos}px)`;
        }
      });
    }

    // Add scroll event listener with throttling for better performance
    let ticking = false;
    function handleScroll() {
      if (!ticking) {
        requestAnimationFrame(() => {
          updateParallax();
          ticking = false;
        });
        ticking = true;
      }
    }

    window.addEventListener('scroll', handleScroll);
    
    // Initial call
    updateParallax();
  }

  // Initialize parallax
  setupParallax();


  // Carousel logic for reviews
  const reviewsList = document.querySelector('.reviews-list');
  const reviewCards = Array.from(document.querySelectorAll('.review-card'));
  const leftArrow = document.querySelector('.reviews-icon-left');
  const rightArrow = document.querySelector('.reviews-icon-right');
  let current = 0;
  
  // Function to get number of visible cards based on screen size
  function getVisibleCards() {
    const width = window.innerWidth;
    if (width <= 768) return 1; // Mobile: 1 card
    if (width <= 1024) return 2; // Tablet: 2 cards
    return 3; // Desktop: 3 cards
  }
  
  function updateCarousel() {
    const visible = getVisibleCards();
    reviewCards.forEach((card, i) => {
      if (i >= current && i < current + visible) {
        card.style.display = '';
      } else {
        card.style.display = 'none';
      }
    });
  }
  
  updateCarousel();
  
  // Update carousel on window resize
  window.addEventListener('resize', function() {
    // Reset current index if it would show too few cards
    const visible = getVisibleCards();
    if (current > reviewCards.length - visible) {
      current = Math.max(0, reviewCards.length - visible);
    }
    updateCarousel();
  });
    leftArrow.addEventListener('click', function () {
    const visible = getVisibleCards();
    if (current > 0) {
      current = current - 1;
    } else {
      current = Math.max(0, reviewCards.length - visible); // Loop to end
    }
    updateCarousel();
  });
  
  rightArrow.addEventListener('click', function () {
    const visible = getVisibleCards();
    if (current < reviewCards.length - visible) {
      current = current + 1;
    } else {
      current = 0; // Loop back to start
    }
    updateCarousel();
  });
});