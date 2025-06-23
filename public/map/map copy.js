// LOGO + BACK TO TOP POSITION

window.addEventListener('scroll', function() {
  const logo = document.querySelector('.logo');
  const backTotop = document.querySelector('.back-to-top');
  if (window.scrollY >= 100) {
    logo.classList.add('logo-extended');
    backTotop.classList.add('back-to-top-active');
  } else {
    logo.classList.remove('logo-extended');
    backTotop.classList.remove('back-to-top-active');
  }
});

// FADE-IN

document.addEventListener("DOMContentLoaded", function() {
  // Select all elements with the class 'fade-out'
  const fadeElements = document.querySelectorAll('.fade-out');

  // Set up the Intersection Observer options
  const observerOptions = {
    root: null, // use the viewport as the container
    // The bottom margin is set to -150px so the callback triggers when
    // the element is within 150px of the viewport's bottom.
    rootMargin: "0px 0px -150px 0px",
    threshold: 0 // Trigger as soon as any part is visible
  };

  // Callback function when elements intersect
  const observerCallback = (entries, observer) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        // Add the 'fade-in' class when the element enters the viewport
        entry.target.classList.add('fade-in');
        // Optionally, if you want the effect to occur only once, unobserve the element:
        observer.unobserve(entry.target);
      }
    });
  };

  // Create the Intersection Observer
  const observer = new IntersectionObserver(observerCallback, observerOptions);

  // Observe each fade-out element
  fadeElements.forEach(el => observer.observe(el));
});



// PARALLAX

document.addEventListener('scroll', function() {
  const scrollPos = window.scrollY; // current scroll position

  // Global settings for all parallax elements:
  const globalSpeed = 0.1;     // Change to a lower value for a slower effect or use a negative value to invert
  const globalOffset = 0;      // Starting offset in pixels (e.g., 50 would start 50px from the normal position)
  const globalAxis = 'y';      // 'y' for vertical (default) or 'x' for horizontal

  // Apply the effect to all elements with the 'parallax' class
  document.querySelectorAll('.parallax').forEach(function(el) {
    // Calculate the transform offset using the global settings
    const offset = globalOffset + scrollPos * globalSpeed;

    // Apply transformation based on the chosen axis
    if (globalAxis.toLowerCase() === 'x') {
      el.style.transform = `translateX(${offset}px)`;
    } else {
      el.style.transform = `translateY(${offset}px)`;
    }
  });
});


// END PARALLAX


// 1. Animate number from 0 to target over a given duration (in ms)
function animateValue(obj, start, end, duration) {
  let startTimestamp = null;
  function step(timestamp) {
    if (!startTimestamp) startTimestamp = timestamp;
    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
    obj.innerText = Math.floor(progress * (end - start) + start);
    if (progress < 1) {
      window.requestAnimationFrame(step);
    } else {
      // Mark this element as animated once finished
      obj.dataset.animated = "true";
    }
  }
  window.requestAnimationFrame(step);
}

// 2. Store original numbers as data attributes (so they persist)
document.querySelectorAll('.region-title p').forEach(p => {
  p.dataset.target = p.innerText;
  // Initialize the flag to false (or leave it undefined)
  p.dataset.animated = "false";
  // Optionally, set a transition for opacity (or add this in your CSS)
  p.style.transition = "opacity 1s";
});

//
// MAP
//

//
// ORIGINAL REGIONS HOVER EFFECTS (move region to top when hovered)
//
document.querySelectorAll('.region').forEach(region => {
  // Add pointer-events CSS (crucial for SVG interaction)
  region.style.pointerEvents = 'auto';

  region.addEventListener('mouseenter', () => {
    // Move the parent <a> element to end of SVG container
    const parentSVG = region.parentNode.parentNode;
    parentSVG.appendChild(region.parentNode);
    
    // Add hover class
    document.querySelectorAll('.info-container').forEach(el => el.classList.add('info-container-b'));
  });

  region.addEventListener('mouseleave', () => {
    // Remove hover class
    document.querySelectorAll('.info-container').forEach(el => el.classList.remove('info-container-b'));
  });
});

//
// REGIONS HOVER EFFECTS (color changes, count‑up and opacity animation)
// triggered when hovering on the SVG regions (e.g. #region-1, #region-2, #region-3, #region-4)
//
document.querySelectorAll('#region-1').forEach(region => {
  region.addEventListener('mouseenter', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.add('info-container-b'));
    document.querySelectorAll('#region-title-1').forEach(title => {
      title.classList.add('active');
      const pEl = title.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    });
  });
  region.addEventListener('mouseleave', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.remove('info-container-b'));
    document.querySelectorAll('#region-title-1').forEach(title => title.classList.remove('active'));
  });
});

document.querySelectorAll('#region-2').forEach(region => {
  region.addEventListener('mouseenter', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.add('info-container-b'));
    document.querySelectorAll('#region-title-2').forEach(title => {
      title.classList.add('active');
      const pEl = title.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    });
  });
  region.addEventListener('mouseleave', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.remove('info-container-b'));
    document.querySelectorAll('#region-title-2').forEach(title => title.classList.remove('active'));
  });
});

document.querySelectorAll('#region-3').forEach(region => {
  region.addEventListener('mouseenter', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.add('info-container-b'));
    document.querySelectorAll('#region-title-3').forEach(title => {
      title.classList.add('active');
      const pEl = title.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    });
  });
  region.addEventListener('mouseleave', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.remove('info-container-b'));
    document.querySelectorAll('#region-title-3').forEach(title => title.classList.remove('active'));
  });
});

// New code for region-4 (and region-title-4)
document.querySelectorAll('#region-4').forEach(region => {
  region.addEventListener('mouseenter', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.add('info-container-b'));
    document.querySelectorAll('#region-title-4').forEach(title => {
      title.classList.add('active');
      const pEl = title.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    });
  });
  region.addEventListener('mouseleave', () => {
    document.querySelectorAll('.info-container').forEach(el => el.classList.remove('info-container-b'));
    document.querySelectorAll('#region-title-4').forEach(title => title.classList.remove('active'));
  });
});

//
// MENU HOVER EFFECTS (applied when hovering on the region titles)
//
document.querySelectorAll('#region-title-1').forEach(titleEl => {
  titleEl.addEventListener('mouseenter', () => {
    const regionElement = document.querySelector('#region-1');
    regionElement.parentNode.append(regionElement);
    setTimeout(() => {
      regionElement.classList.add('active');
      const pEl = titleEl.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    }, 10);
  });
  titleEl.addEventListener('mouseleave', () => {
    document.querySelectorAll('#region-1').forEach(region => region.classList.remove('active'));
  });
});

document.querySelectorAll('#region-title-2').forEach(titleEl => {
  titleEl.addEventListener('mouseenter', () => {
    const regionElement = document.querySelector('#region-2');
    regionElement.parentNode.append(regionElement);
    setTimeout(() => {
      regionElement.classList.add('active');
      const pEl = titleEl.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    }, 10);
  });
  titleEl.addEventListener('mouseleave', () => {
    document.querySelectorAll('#region-2').forEach(region => region.classList.remove('active'));
  });
});

document.querySelectorAll('#region-title-3').forEach(titleEl => {
  titleEl.addEventListener('mouseenter', () => {
    const regionElement = document.querySelector('#region-3');
    regionElement.parentNode.append(regionElement);
    setTimeout(() => {
      regionElement.classList.add('active');
      const pEl = titleEl.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    }, 10);
  });
  titleEl.addEventListener('mouseleave', () => {
    document.querySelectorAll('#region-3').forEach(region => region.classList.remove('active'));
  });
});

document.querySelectorAll('#region-title-4').forEach(titleEl => {
  titleEl.addEventListener('mouseenter', () => {
    const regionElement = document.querySelector('#region-4');
    regionElement.parentNode.append(regionElement);
    setTimeout(() => {
      regionElement.classList.add('active');
      const pEl = titleEl.querySelector('p');
      if (pEl && pEl.dataset.animated !== "true") {
        const finalVal = parseInt(pEl.dataset.target, 10);
        pEl.innerText = "0";
        pEl.style.opacity = 0;
        setTimeout(() => {
          pEl.style.opacity = 1;
          animateValue(pEl, 0, finalVal, 1000);
        }, 10);
      }
    }, 10);
  });
  titleEl.addEventListener('mouseleave', () => {
    document.querySelectorAll('#region-4').forEach(region => region.classList.remove('active'));
  });
});

//
// General hover effect for .info-container elements
//
document.querySelectorAll('.info-container').forEach(infoContainer => {
  infoContainer.addEventListener('mouseenter', () => {
    infoContainer.classList.add('info-container-b');
  });
  infoContainer.addEventListener('mouseleave', () => {
    infoContainer.classList.remove('info-container-b');
  });
});



  

// PROJECT IMAGES

document.addEventListener("DOMContentLoaded", function() {
  // Select all project elements
  const projects = document.querySelectorAll(".project");

  projects.forEach(project => {
    // Get slider elements for the current project
    const slidesContainer = project.querySelector(".slides");
    const slides = slidesContainer.querySelectorAll(".project-img");
    const leftArrow = project.querySelector(".slider-arrow.left");
    const rightArrow = project.querySelector(".slider-arrow.right");
    const dotsContainer = project.querySelector(".slider-dots");
    
    let currentIndex = 0;

    // Update the active slide and dot
    function updateSlider() {
      slides.forEach((slide, index) => {
        slide.classList.toggle("active", index === currentIndex);
      });
      const dots = dotsContainer.querySelectorAll(".dot");
      dots.forEach((dot, index) => {
        dot.classList.toggle("active", index === currentIndex);
      });
    }

    // Generate slider dots for the current project
    function generateDots() {
      dotsContainer.innerHTML = ""; // Clear existing dots
      slides.forEach((slide, index) => {
        const dot = document.createElement("span");
        dot.classList.add("dot");
        if (index === currentIndex) {
          dot.classList.add("active");
        }
        dot.addEventListener("click", function() {
          currentIndex = index;
          updateSlider();
        });
        dotsContainer.appendChild(dot);
      });
    }

    // Add event listeners for arrow navigation
    leftArrow.addEventListener("click", function() {
      currentIndex = (currentIndex - 1 + slides.length) % slides.length;
      updateSlider();
    });

    rightArrow.addEventListener("click", function() {
      currentIndex = (currentIndex + 1) % slides.length;
      updateSlider();
    });

    // Initialize slider for the current project
    generateDots();
    updateSlider();
  });
});


// END PROJECT  IMGS