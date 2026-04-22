$(document).ready(function () {
  $(".popup-gallery").magnificPopup({
    delegate: "a",
    type: "image",
    gallery: {
      enabled: true,
      navigateByImgClick: true,
    },
  });
});

!(function (e) {
  "use strict";
  $(".banner-carousel").owlCarousel({
    items: 1,
    loop: true,
    autoplay: true,
    autoplayTimeout: 7000,
    smartSpeed: 2500,
    animateOut: "owl-fade-out",
    animateIn: "owl-fade-in",
    mouseDrag: true,
    touchDrag: true,
    dots: true,
    nav: false,
  });

  let header = document.getElementById("navbar");

  window.addEventListener("scroll", function () {
    if (!header) return;

    if (window.scrollY > 450) {
      header.classList.add("scrolled");
    } else {
      header.classList.remove("scrolled");
    }
  });
})();

function openVideo() {
  const modal = document.getElementById("videoModal");
  const iframe = document.getElementById("videoFrame");
  const videoId = "YOUR_VIDEO_ID_HERE";
  iframe.src = `https://www.youtube.com/embed/t_KKNNeH8jU?autoplay=1`;
  modal.style.display = "flex";
}

function closeVideo() {
  const modal = document.getElementById("videoModal");
  const iframe = document.getElementById("videoFrame");
  modal.style.display = "none";
  iframe.src = "";
}

window.onclick = function (event) {
  const modal = document.getElementById("videoModal");
  if (event.target == modal) {
    closeVideo();
  }
};

// =================================
// SME Card Design
// =================================

function openTab(evt, tabName) {
  var i, tabContent;
  tabContent = document.getElementsByClassName("tab-content");
  for (i = 0; i < tabContent.length; i++) {
    tabContent[i].classList.remove("active");
  }
  var navItems = document.getElementsByClassName("nav-item");
  for (i = 0; i < navItems.length; i++) {
    navItems[i].classList.remove("active");
  }
  var tabLinks = document.getElementsByClassName("tab-item");
  for (i = 0; i < tabLinks.length; i++) {
    tabLinks[i].classList.remove("active");
  }
  var el = document.getElementById(tabName);
  if (el) el.classList.add("active");
  if (evt && evt.currentTarget) {
    evt.currentTarget.classList.add("active");
    evt.currentTarget.scrollIntoView({
      behavior: "smooth",
      block: "center",
      inline: "center",
    });
  } else {
    var navtarget = document.querySelector(
      ".segment-nav .nav-item[data-tab='" + tabName + "']",
    );
    if (!navtarget) {
      navtarget = document.querySelector(
        ".segment-nav .nav-item[onclick*='openTab(event, \"" +
          tabName +
          "\")']",
      );
    }
    if (navtarget) {
      navtarget.classList.add("active");
      navtarget.scrollIntoView({
        behavior: "smooth",
        block: "center",
        inline: "center",
      });
    }
  }
}

function getTabNameFromButton(button) {
  if (!button) return null;
  var tabName = button.getAttribute("data-tab");
  if (tabName) return tabName;
  var onclick = button.getAttribute("onclick");
  if (!onclick) return null;
  var match = onclick.match(
    /openTab\s*\(\s*event\s*,\s*['\"]([^'\"]+)['\"]\s*\)/,
  );
  return match ? match[1] : null;
}

function switchTabInContainer(container, direction) {
  if (!container) return;
  var navItems = Array.from(container.querySelectorAll(".nav-item"));
  if (!navItems.length) return;

  var active = container.querySelector(".nav-item.active");
  if (!active) active = navItems[0];

  var currentIndex = navItems.indexOf(active);
  if (currentIndex === -1) return;

  var nextIndex =
    (currentIndex + direction + navItems.length) % navItems.length;
  var nextButton = navItems[nextIndex];
  if (!nextButton) return;

  nextButton.click();
}

function initSegmentNavArrows() {
  console.log("Nav arrows initialized.");
}

if (document.readyState === "loading") {
  document.addEventListener("DOMContentLoaded", initSegmentNavArrows);
} else {
  initSegmentNavArrows();
}

function switchCategory(categoryId) {
  const sections = document.querySelectorAll(".category-section");
  sections.forEach((section) => section.classList.remove("active"));

  const target = document.getElementById(categoryId);
  if (!target) return;
  target.classList.add("active");

  try {
    const navContainer = target.querySelector(".segment-nav");
    if (navContainer) {
      const anyActive = navContainer.querySelector(".nav-item.active");
      const firstNav = navContainer.querySelector(".nav-item");
      if (anyActive) {
        anyActive.click();
      } else if (firstNav) {
        firstNav.click();
      }
    }
  } catch (e) {
    console.error("switchCategory init error", e);
  }
}
$(document).ready(function () {
  var btn = $("#backToTop");

  function checkScroll() {
    if ($(window).scrollTop() > 450) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  }

  checkScroll();

  $(window).scroll(function () {
    checkScroll();
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").stop().animate(
      {
        scrollTop: 0,
      },
      800,
    );
  });
});

const loanSelect = document.getElementById("loanSelect");
if (loanSelect) {
  const trigger = loanSelect.querySelector(".select-trigger");
  const options = loanSelect.querySelectorAll(".option");

  // Click kore dropdown khola ba bondho kora
  if (trigger) {
    trigger.addEventListener("click", () => {
      loanSelect.classList.toggle("active");
    });
  }

  options.forEach((option) => {
    option.addEventListener("click", function () {
      const span = trigger ? trigger.querySelector("span") : null;
      if (span) {
        span.innerText = this.innerText;
        span.style.color = "#334155";
      }
      loanSelect.classList.remove("active");
    });
  });

  window.addEventListener("click", (e) => {
    if (!loanSelect.contains(e.target)) {
      loanSelect.classList.remove("active");
    }
  });
}

const modal = document.getElementById("bioModal");

function openModal(card) {
  const name = card.querySelector("h3").innerText;
  const designation = card.querySelector("p").innerText;
  const imgPath = card.querySelector("img").src;
  const description = card.getAttribute("data-description") || "Information will be updated soon.";
  document.getElementById("modalName").innerText = name;
  document.getElementById("modalDesignation").innerText = designation;
  document.getElementById("modalImg").src = imgPath;
  document.getElementById("modalDesc").innerHTML = description;
  modal.style.display = "block";
}

// const closeBtn = document.querySelector(".close-btn");
// if (closeBtn) {
//   closeBtn.onclick = function () {
//     modal.style.display = "none";
//   };
// }

window.onclick = function (event) {
  if (event.target == modal) {
    modal.style.display = "none";
  }
};

// =================================
// Corporate Slider
// =================================

var swiper = new Swiper(".blog-grid", {
  slidesPerView: 1,
  spaceBetween: 30,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop: true,
  dots: true,
  autoplay: true,
  autoplayTimeout: 5000,
  breakpoints: {
    640: {
      slidesPerView: 2,
      spaceBetween: 30,
    },
    768: {
      slidesPerView: 3,
      spaceBetween: 30,
    },
    1024: {
      slidesPerView: 4,
      spaceBetween: 30,
    },
  },
});

var swiper = new Swiper(".loanSlider", {
  slidesPerView: 2,
  spaceBetween: 15,
  pagination: {
    el: ".swiper-pagination",
    clickable: true,
  },
  loop: true,
  dots: true,
  autoplay: true,
  autoplayTimeout: 5000,
  delay: 50000,
  breakpoints: {
    640: {
      slidesPerView: 3,
      spaceBetween: 15,
    },
    768: {
      slidesPerView: 4,
      spaceBetween: 15,
    },
    1224: {
      slidesPerView: 5,
      spaceBetween: 15,
    },
    1440: {
      slidesPerView: 6,
      spaceBetween: 15,
    },
  },
});

const menu = document.querySelector(".make-sticky");
const stickyPoint = menu.offsetTop;

window.addEventListener("scroll", () => {
  if (window.scrollY > stickyPoint) {
    menu.classList.add("sticky");
  } else {
    menu.classList.remove("sticky");
  }
});

const carousel3Dswiper = new Swiper(".carousel-3D-swiper", {
  loop: true,
  effect: "coverflow",
  grabCursor: true,
  centeredSlides: true,
  slidesPerView: 3,
  coverflowEffect: {
    rotate: 0,
    stretch: 0,
    depth: 274,
    modifier: 1,
    slideShadows: true,
  },
  navigation: {
    nextEl: ".swiper-button-next",
    prevEl: ".swiper-button-prev",
  },
  // pagination: {
  //     el: ".swiper-pagination"
  // }
});
