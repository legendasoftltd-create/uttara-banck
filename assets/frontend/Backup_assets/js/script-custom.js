!(function (e) {
  "use strict";
  //  const swiperElm = document.querySelectorAll(".thm-swiper__slider");
  // swiperElm.forEach(function (swiperelm) {
  //   const swiperOptions = JSON.parse(swiperelm.dataset.swiperOptions);
  //   let thmSwiperSlider = new Swiper(swiperelm, swiperOptions);
  // });
  // banner-carousel

$('.banner-carousel').owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 7000,
    smartSpeed: 2500,      
    animateOut: 'owl-fade-out',
    animateIn: 'owl-fade-in',
    mouseDrag: false,
    touchDrag: true,
    dots: true,
    nav: false
});




    window.addEventListener("scroll", function () {
      let header = document.getElementById("navbar");
      if (window.scrollY > 450) {
        header.classList.add("scrolled");
      } else {
        header.classList.remove("scrolled");
      }
    });

})();


function openVideo() {
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoFrame');
    
    // আপনার ইউটিউব ভিডিও আইডি এখানে দিন (যেমন: 'dQw4w9WgXcQ')
    const videoId = 'YOUR_VIDEO_ID_HERE'; 
    iframe.src = `https://www.youtube.com/embed/t_KKNNeH8jU?autoplay=1`;
    
    modal.style.display = 'flex';
}

function closeVideo() {
    const modal = document.getElementById('videoModal');
    const iframe = document.getElementById('videoFrame');
    
    modal.style.display = 'none';
    iframe.src = ""; // ভিডিও বন্ধ করার জন্য সোর্স ক্লিয়ার করা
}

// মোডালের বাইরে ক্লিক করলে বন্ধ হবে
window.onclick = function(event) {
    const modal = document.getElementById('videoModal');
    if (event.target == modal) {
        closeVideo();
    }
}


// =================================
// SME Card Design
// =================================

function openTab(evt, tabName) {
    var i, tabContent;

    // Hide all tab contents
    tabContent = document.getElementsByClassName("tab-content");
    for (i = 0; i < tabContent.length; i++) {
        tabContent[i].classList.remove("active");
    }

    // Remove active from nav buttons (.nav-item) if any
    var navItems = document.getElementsByClassName("nav-item");
    for (i = 0; i < navItems.length; i++) {
        navItems[i].classList.remove("active");
    }

    // Remove active from other tab buttons (.tab-item) as well
    var tabLinks = document.getElementsByClassName("tab-item");
    for (i = 0; i < tabLinks.length; i++) {
        tabLinks[i].classList.remove("active");
    }

    // Show the requested tab content
    var el = document.getElementById(tabName);
    if (el) el.classList.add("active");

    // Mark the clicked nav button active
    if (evt && evt.currentTarget) {
        evt.currentTarget.classList.add("active");
        evt.currentTarget.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
    } else {
        // If openTab called programmatically, set nav-item active by tab name
        var navtarget = document.querySelector(".segment-nav .nav-item[data-tab='" + tabName + "']");
        if (!navtarget) {
            navtarget = document.querySelector(".segment-nav .nav-item[onclick*='openTab(event, \"" + tabName + "\")']");
        }
        if (navtarget) {
            navtarget.classList.add("active");
            navtarget.scrollIntoView({ behavior: 'smooth', block: 'center', inline: 'center' });
        }
    }
}

function getTabNameFromButton(button) {
    if (!button) return null;
    var tabName = button.getAttribute('data-tab');
    if (tabName) return tabName;
    var onclick = button.getAttribute('onclick');
    if (!onclick) return null;
    var match = onclick.match(/openTab\s*\(\s*event\s*,\s*['\"]([^'\"]+)['\"]\s*\)/);
    return match ? match[1] : null;
}

function switchTabInContainer(container, direction) {
    if (!container) return;
    var navItems = Array.from(container.querySelectorAll('.nav-item'));
    if (!navItems.length) return;

    var active = container.querySelector('.nav-item.active');
    if (!active) active = navItems[0];

    var currentIndex = navItems.indexOf(active);
    if (currentIndex === -1) return;

    var nextIndex = (currentIndex + direction + navItems.length) % navItems.length;
    var nextButton = navItems[nextIndex];
    if (!nextButton) return;

    // Trigger normal click behavior to keep universal tab logic
    nextButton.click();
}

// Fallback for missing initSegmentNavArrows to prevent error
function initSegmentNavArrows() {
    console.log("Nav arrows initialized.");
}

// Initialize arrows after DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initSegmentNavArrows);
} else {
    initSegmentNavArrows();
}

function switchCategory(categoryId) {
    // Hide all main category sections
    const sections = document.querySelectorAll('.category-section');
    sections.forEach(section => section.classList.remove('active'));

    // Show the selected one
    const target = document.getElementById(categoryId);
    if (!target) return;
    target.classList.add('active');

    // Ensure the sub-tabs inside this category have an active state.
    // If there's no .nav-item with .active, click the first .nav-item to initialize its tab.
    try {
        const navContainer = target.querySelector('.segment-nav');
        if (navContainer) {
            const anyActive = navContainer.querySelector('.nav-item.active');
            const firstNav = navContainer.querySelector('.nav-item');
            if (anyActive) {
                // Re-trigger click to ensure corresponding tab-content is shown
                anyActive.click();
            } else if (firstNav) {
                firstNav.click();
            }
        }
    } catch (e) {
        // Fail silently — don't block switching if something unexpected exists
        console.error('switchCategory init error', e);
    }
}
$(document).ready(function() {
    var btn = $('#backToTop');

    // ১. একটি ফাংশন তৈরি করুন যা চেক করবে বাটন দেখানো উচিত কি না
    function checkScroll() {
        if ($(window).scrollTop() > 450) {
            btn.addClass('show');
        } else {
            btn.removeClass('show');
        }
    }

    // ২. পেজ লোড হওয়ার সাথে সাথে একবার চেক করবে (রিলোড প্রবলেম সলভ করবে)
    checkScroll();

    // ৩. স্ক্রল করার সময় চেক করবে
    $(window).scroll(function() {
        checkScroll();
    });

    // বাটনে ক্লিক করলে ওপরে যাওয়ার জন্য (ইজিয়িং বাদে নিরাপদ কোড)
    btn.on('click', function(e) {
        e.preventDefault();
        $('html, body').stop().animate({
            scrollTop: 0
        }, 800); 
    });
});


const loanSelect = document.getElementById('loanSelect');
if (loanSelect) {
    const trigger = loanSelect.querySelector('.select-trigger');
    const options = loanSelect.querySelectorAll('.option');

    // Click kore dropdown khola ba bondho kora
    if (trigger) {
        trigger.addEventListener('click', () => {
            loanSelect.classList.toggle('active');
        });
    }

    // Option select korle text change hobe
    options.forEach(option => {
        option.addEventListener('click', function() {
            const span = trigger ? trigger.querySelector('span') : null;
            if (span) {
                span.innerText = this.innerText;
                span.style.color = "#334155"; // Active text color
            }
            loanSelect.classList.remove('active');
        });
    });

    // Screen-er onno kothao click korle dropdown bondho hoye jabe
    window.addEventListener('click', (e) => {
        if (!loanSelect.contains(e.target)) {
            loanSelect.classList.remove('active');
        }
    });
}

