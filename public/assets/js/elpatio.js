// FADE-IN-1

const sections = document.querySelectorAll('.fadeIn');
const options = {
  root: null,
  threshold: 0.1,
};

const observer = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('fade-in');
      observer.unobserve(entry.target);
    }
  });
}, options);

sections.forEach(section => {
  observer.observe(section);
});

// END FADE-IN-1

// FADE-IN-2

const sections2 = document.querySelectorAll('.fadeIn2');


const observer2 = new IntersectionObserver((entries, observer) => {
  entries.forEach(entry => {
    if (entry.isIntersecting) {
      entry.target.classList.add('fade-in-2');
      observer.unobserve(entry.target);
    }
  });
}, options);

sections2.forEach(section => {
  // BUGFIX: use observer2 so .fadeIn2 elements get 'fade-in-2' class
  observer2.observe(section);
});

// END FADE-IN-2



// ICONS

document.addEventListener("DOMContentLoaded", function() {
  function randomizeIcons() {
      const icons = document.querySelectorAll('.icons img');
      const usedNumbers = new Set(); // Keep track of used numbers to avoid duplicates

      icons.forEach(img => {
          let randomNumber;
          do {
              randomNumber = Math.floor(Math.random() * 12) + 1; // Number between 1 and 12
          } while (usedNumbers.has(randomNumber)); // Ensure uniqueness

          usedNumbers.add(randomNumber);
          // Use root-relative path so it works on multiple domains pointing to same Laravel public dir
          img.src = `/assets/elpatio/imgs/icon${randomNumber}.png`;
      });
  }

  randomizeIcons(); // Run on page load
  setInterval(randomizeIcons, 1200); // Run every 1.2 seconds
});


// SLIDER


document.addEventListener('DOMContentLoaded', function() {
  const slider = document.querySelector('#section2 .slider');
  const sliderTrack = document.querySelector('#section2 .slider-track');
  const slides = document.querySelectorAll('#section2 .slide');
  const bullets = document.querySelectorAll('#section2 .bullet');
  
  let currentIndex = 0;
  let isAnimating = false;
  let autoTimer;
  
  // Variables for drag functionality.
  let startX = 0;
  let currentTranslate = 0;
  let prevTranslate = 0;
  let isDragging = false;

  // Helper: Update bullet active states.
  function updateBullets() {
    bullets.forEach((bullet, idx) => {
      bullet.classList.toggle('active', idx === currentIndex);
    });
  }
  
  // Go to the target slide with a transition.
  function goToSlide(index) {
    if (isAnimating || index === currentIndex) return;
    isAnimating = true;
    // Enable transition for the slide animation.
    sliderTrack.style.transition = 'transform 0.6s ease';
    sliderTrack.style.transform = `translateX(-${index * 100}%)`;
    currentIndex = index;
    updateBullets();
    resetTimer();
    // When transition ends, release the animation lock.
    sliderTrack.addEventListener('transitionend', function te(e) {
      // Ensure we only act on the transform property.
      if(e.propertyName === 'transform'){
        isAnimating = false;
        sliderTrack.removeEventListener('transitionend', te);
      }
    });
  }
  
  // Restart the auto-advance timer.
  function resetTimer() {
    clearTimeout(autoTimer);
    autoTimer = setTimeout(() => {
      let nextIndex = (currentIndex + 1) % slides.length;
      goToSlide(nextIndex);
    }, 8000);
  }
  
  // Bullet click events.
  bullets.forEach((bullet) => {
    bullet.addEventListener('click', () => {
      const index = parseInt(bullet.getAttribute('data-index'));
      // Reset timer and slide if not already animating.
      goToSlide(index);
    });
  });
  
  // Start the auto-advance timer.
  resetTimer();
  
  // --- Drag functionality (mouse and touch) ---
  // Get the X position from a mouse or touch event.
  function getPositionX(e) {
    return e.type.includes('mouse') ? e.pageX : e.touches[0].clientX;
  }
  
  function dragStart(e) {
    if (isAnimating) return;
    clearTimeout(autoTimer); // Stop auto slide while dragging.
    isDragging = true;
    startX = getPositionX(e);
    // Disable transition so we can move freely.
    sliderTrack.style.transition = 'none';
  }
  
  function dragMove(e) {
    if (!isDragging) return;
    const currentPosition = getPositionX(e);
    const diff = currentPosition - startX;
    // Calculate the current translation based on drag.
    currentTranslate = prevTranslate + diff;
    sliderTrack.style.transform = `translateX(${currentTranslate}px)`;
  }
  
  function dragEnd() {
    if (!isDragging) return;
    isDragging = false;
    const movedBy = currentTranslate - prevTranslate;
    // Threshold for triggering a slide change.
    if (movedBy < -100 && currentIndex < slides.length - 1) {
      goToSlide(currentIndex + 1);
    } else if (movedBy > 100 && currentIndex > 0) {
      goToSlide(currentIndex - 1);
    } else {
      // If not enough movement, snap back to the current slide.
      sliderTrack.style.transition = 'transform 0.6s ease';
      sliderTrack.style.transform = `translateX(-${currentIndex * 100}%)`;
    }
    // Update the reference for the next drag.
    prevTranslate = -currentIndex * slider.offsetWidth;
  }
  
  // Event listeners for mouse events.
  slider.addEventListener('mousedown', dragStart);
  slider.addEventListener('mousemove', dragMove);
  slider.addEventListener('mouseup', dragEnd);
  slider.addEventListener('mouseleave', () => { if (isDragging) dragEnd(); });
  
  // Event listeners for touch events.
  slider.addEventListener('touchstart', dragStart);
  slider.addEventListener('touchmove', dragMove);
  slider.addEventListener('touchend', dragEnd);
  
  // Optional: Prevent image dragging (the browser's default behavior)
  slides.forEach(slide => {
    slide.addEventListener('dragstart', (e) => e.preventDefault());
  });
  
  // Initialize prevTranslate to match the starting slide.
  prevTranslate = -currentIndex * slider.offsetWidth;
});

