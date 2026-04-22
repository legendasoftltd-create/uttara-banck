if ($(window).height() > 700) {
  $(".xl").removeClass("xl");
} else {
  $(".md").removeClass("md");
}

$("#menutrigger").on("click", function () {
  if ($(".qmenu-btn").hasClass("fa-align-justify")) {
    $(".qmenu-btn").removeClass("fa-align-justify");
    $(".qmenu-btn").addClass("fa-times");
  } else {
    $(".qmenu-btn").addClass("fa-align-justify");
    $(".qmenu-btn").removeClass("fa-times");
  }
});

if ($(window).width() < 700) {
  $(".moremenu").css("display", "block"); // you can also use $(".yourClass").hide();
} else {
  $(".moremenu").css("display", "none"); // you can also use $(".yourClass").hide();
}

$("#whatseNewCarousel").on("slide.bs.carousel", function (e) {
  var $e = $(e.relatedTarget);
  var idx = $e.index();
  var itemsPerSlide = 4;
  var totalItems = $("#whatseNewCarousel .carousel-item").length;

  if (idx >= totalItems - (itemsPerSlide - 1)) {
    var it = itemsPerSlide - (totalItems - idx);
    for (var i = 0; i < it; i++) {
      // append slides to end
      if (e.direction == "left") {
        $("#whatseNewCarousel .carousel-item")
          .eq(i)
          .appendTo("#whatseNewCarousel .carousel-inner");
      } else {
        $("#whatseNewCarousel .carousel-item")
          .eq(0)
          .appendTo("#whatseNewCarousel .carousel-inner");
      }
    }
  }
});

// picker buttton
jQuery(".picker_close").click(function () {
  //jQuery(".tooltip-inner").toggleClass("position");
  //jQuery('.tooltip-inner').css('display', 'none');
  //jQuery('.ui-tooltip').hide();
  jQuery('[data-toggle="tooltip"]').tooltip("hide");
  //alert(1);
  //jQuery('[data-toggle="tooltip"]').tooltip();
  jQuery("#choose_color").toggleClass("position");

  if (jQuery(".picker_close .qmenu-btn").hasClass("fa-wheelchair")) {
    jQuery(".picker_close .qmenu-btn").removeClass("fa-wheelchair");
    jQuery(".picker_close .qmenu-btn").addClass("fa-times");
  } else {
    jQuery(".picker_close .qmenu-btn").addClass("fa-wheelchair");
    jQuery(".picker_close .qmenu-btn").removeClass("fa-times");
  }
});

function decreaseFontSize() {
  var resizable_elements = $("a,p,span,ul,ol,h1,h2,h3,h4,h5,h6,td,th");
  resizable_elements.each(function () {
    var b = parseInt($(this).css("font-size"));
    if (b > 12) {
      $(this).css("font-size", parseInt(b - 1) + "px", "important");
      console.log($(this));
    }
  });
  //toggle button highlight
}

function increaseFontSize() {
  var resizable_elements = $("a,p,span,ul,ol,h1,h2,h3,h4,h5,h6,td,th");
  resizable_elements.each(function () {
    if (!$(this).hasClass("sr screen-reader")) {
      var b = parseInt($(this).css("font-size"));
      $(this).css("font-size", parseInt(b + 1) + "px", "important");
    }
  });
  //toggle button highlight
}
var clicks = 0;
function increaseTextspSize() {
  clicks += 1;
  var resizable_elements = $("a,p,span,ul,ol,h1,h2,h3,h4,h5,h6,td,th");
  resizable_elements.each(function () {
    var b = parseInt($(this).css("letter-spacing"));
    //alert(b);
    if (b > 4) {
      $(this).css("letter-spacing", "", "!important");
      clicks = 0;
      //console.log($(this));
    } else {
      $(this).css("letter-spacing", parseInt(b + 1) + "px", "important");

    }
  });
  //toggle button highlight
}

var clicks = 0;
function increaseLineSize() {
  clicks += 1;
  var resizable_elements = $("p,span,h1,h2,h3,h4,h5,h6,td,th");
  resizable_elements.each(function () {
    var b = parseInt($(this).css("line-height"));
    if (clicks == 8) {
      // $(this).removeAttr("style");
      $("p,span,h1,h2,h3,h4,h5,h6,td,th").css("line-height", "", "important");
      clicks = 0;
    } else {
      $(this).css("line-height", parseInt(b + 1) + "px", "important");

    }
  });
}

function highlightLinks() {
  $("a").each(function () {
    $(this).toggleClass("selected");
  });
  $("#apHighlight").toggleClass("btnselected");
}

function underlineLinks() {
  $("a").each(function () {
    $(this).toggleClass("underline");
  });
  $("#apUnderline").toggleClass("btnselected");
}

jQuery("#ahrfHighlight").click(function () {
  $("a").each(function () {
    $(this).toggleClass("selected");
  });
  $("#ahrfHighlight").toggleClass("btnselected");

  if (!$($("#ahrfHighlight input")).is(":checked")) {
    $("#ahrfHighlight input").prop("checked", true);
  } else {
    $("#ahrfHighlight input").prop("checked", false);
  }
});

jQuery("#ahrlineheight").click(function () {
  $("li,p").each(function () {
    $(this).toggleClass("selected");
  });

  $("#ahrlineheight").toggleClass("btnselected");

  if (!$($("#ahrlineheight input")).is(":checked")) {
    $("#ahrlineheight input").prop("checked", true);
  } else {
    $("#ahrlineheight input").prop("checked", false);
  }
});

jQuery("#Dyslexia").click(function () {
  $("li,p,a").each(function () {
    $(this).toggleClass("dyslexiafont");
  });

  $("#Dyslexia").toggleClass("btnselected");

  if (!$($("#Dyslexia input")).is(":checked")) {
    $("#Dyslexia input").prop("checked", true);
  } else {
    $("#Dyslexia input").prop("checked", false);
  }
});

jQuery("#Monochrome").click(function () {
  $("html").toggleClass("monochrome");
  $("img").each(function () {
    $(this).toggleClass("grayscale");
  });
  $("#Monochrome").toggleClass("btnselected");

  if (!$($("#Monochrome input")).is(":checked")) {
    $("#Monochrome input").prop("checked", true);
  } else {
    $("#Monochrome input").prop("checked", false);
  }
});

jQuery("#invertImages").click(function () {
  $("img").each(function () {
    $(this).toggleClass("inverted");
  });
  $("html").toggleClass("inverted");

  $("#invertImages").toggleClass("btnselected");
  // $("#invertImages input[type='checkbox']").prop("checked", true);
  //alert(1);
  if (!$("#invertImages input[type='checkbox']").is(":checked")) {
    $("#invertImages input[type='checkbox']").prop("checked", true);
  } else {
    $("#invertImages input[type='checkbox']").prop("checked", false);
  }
});

jQuery("#readingguidex").click(function () {
  $("html").toggleClass("guide");
  $("#readingguide").toggleClass("btnselected");
  if (!$("#invertImages input[type='checkbox']").is(":checked")) {
    $("#invertImages input[type='checkbox']").prop("checked", true);
  } else {
    $("#invertImages input[type='checkbox']").prop("checked", false);
  }
});

jQuery("#bigCursor").click(function () {
  $("html").toggleClass("bigCursor");
  $("#bigCursor").toggleClass("btnselected");
  if (!$($("#bigCursor input")).is(":checked")) {
    $("#bigCursor input").prop("checked", true);
  } else {
    $("#bigCursor input").prop("checked", false);
  }
});

jQuery("#readingguide").click(function () {
  //$( "#reading-guide" ).toggleClass("d-none");
  $("html").toggleClass("guide");
  $("#readingguide").toggleClass("btnselected");
  //$("#reading_Guide").css("display", "block");
  $(document).on("mousemove", function (e) {
    $("#reading_Guide").css("top", e.pageY - 15);
  });
  document.getElementById("reading_Guide").style.display = "block";

  if (!$("#readingguide input[type='checkbox']").is(":checked")) {
    $("#readingguide input[type='checkbox']").prop("checked", true);
  } else {
    $("#readingguide input[type='checkbox']").prop("checked", false);
  }
});

jQuery("#accecesbilitclean").click(function () {
  var resizable_elements = $("a,p,span,ul,ol,h1,h2,h3,h4,h5,h6,td,th");
  resizable_elements.each(function () {
    var b = parseInt($(this).css("font-size"));
    $(this).css("font-size", "", "important");
    $(this).css("line-height", "", "important");
    $(this).css("letter-spacing", "", "important");
  });

  $("a").each(function () {
    $(this).removeClass("selected");
  });

  $("img").each(function () {
    $(this).removeClass("grayscale");
    $(this).removeClass("invert");
  });
  $("#Monochrome").removeClass("grayscale");
  $("#bigCursor").removeClass("bigCursor");
  $("html").removeClass("bigCursor");
  $("#invertImages").removeClass("inverted");
  $("#ahrfHighlight").removeClass("btnselected");
  $("html").removeClass("inverted");
  $("html").removeClass("monochrome");
  //$("#ahrfHighlight input").prop("checked", false);
  $("html").removeClass("guide");
  $("input[type='checkbox']").prop("checked", false);
  $("li a").removeClass("btnselected");
});

// End picker buttton

$("#offerCarousel").on("slide.bs.carousel", function (e) {
  var $e = $(e.relatedTarget);
  var idx = $e.index();
  var itemsPerSlide = 4;
  var totalItems = $("#offerCarousel .carousel-item").length;

  if (idx >= totalItems - (itemsPerSlide - 1)) {
    var it = itemsPerSlide - (totalItems - idx);
    for (var i = 0; i < it; i++) {
      // append slides to end
      if (e.direction == "left") {
        $("#offerCarousel .carousel-item")
          .eq(i)
          .appendTo("#offerCarousel .carousel-inner");
      } else {
        $("#offerCarousel .carousel-item")
          .eq(0)
          .appendTo("#offerCarousel .carousel-inner");
      }
    }
  }
});

$("#loanProductsCarousel").on("slide.bs.carousel", function (e) {
  var $e = $(e.relatedTarget);
  var idx = $e.index();
  var itemsPerSlide = 4;
  var totalItems = $("#loanProductsCarousel .carousel-item").length;

  if (idx >= totalItems - (itemsPerSlide - 1)) {
    var it = itemsPerSlide - (totalItems - idx);
    for (var i = 0; i < it; i++) {
      // append slides to end
      if (e.direction == "left") {
        $("#loanProductsCarousel .carousel-item")
          .eq(i)
          .appendTo("#loanProductsCarousel .carousel-inner");
      } else {
        $("#loanProductsCarousel .carousel-item")
          .eq(0)
          .appendTo("#loanProductsCarousel .carousel-inner");
      }
    }
  }
});

const menuBtn = document.getElementById("menuBtn");
const sideMenu = document.getElementById("sideMenu");
const closeMenu = document.getElementById("closeMenu");
const overlay = document.getElementById("overlay");

menuBtn.onclick = () => {
  sideMenu.classList.add("active");
  overlay.classList.add("active");
};

closeMenu.onclick = () => {
  sideMenu.classList.remove("active");
  overlay.classList.remove("active");
};

overlay.onclick = () => {
  sideMenu.classList.remove("active");
  overlay.classList.remove("active");
};

// Dropdown toggle
const dropdownToggles = document.querySelectorAll('.dropdown-toggle');
dropdownToggles.forEach(toggle => {
    toggle.addEventListener('click', (e) => {
        e.preventDefault();
        const parent = toggle.parentElement;
        parent.classList.toggle('active');
    });
});

const searchBtn = document.getElementById("searchBtn");
const searchBox = document.querySelector(".search-box");

searchBtn.onclick = () => {
  searchBox.classList.toggle("active");
};

const data = window.locationData || null;
const tabs = document.querySelectorAll(".tab");
const list = document.getElementById("branchList");
const map = document.getElementById("mapFrame");
const search = document.getElementById("searchInputLocation");

if (data && tabs.length && list && map && search) {
  const availableTabs = Object.keys(data).filter(function (key) {
    return Array.isArray(data[key]) && data[key].length;
  });

  let currentTab =
    Array.from(tabs).find(function (tab) {
      return tab.classList.contains("active") && data[tab.dataset.tab];
    })?.dataset.tab || availableTabs[0] || null;

  function getEmbedUrl(item) {
    if (item.latitude && item.longitude) {
      return (
        "https://maps.google.com/maps?q=" +
        encodeURIComponent(item.latitude + "," + item.longitude) +
        "&t=&z=15&ie=UTF8&iwloc=&output=embed"
      );
    }

    if (item.query) {
      return (
        "https://maps.google.com/maps?q=" +
        encodeURIComponent(item.query) +
        "&t=&z=15&ie=UTF8&iwloc=&output=embed"
      );
    }

    return "";
  }

  function renderMap(item) {
    if (!item) {
      map.innerHTML =
        '<div class="branch-item">No map available for this location.</div>';
      return;
    }

    if (item.map && item.map.toLowerCase().indexOf("<iframe") !== -1) {
      map.innerHTML = item.map;
      return;
    }

    const src = item.map || getEmbedUrl(item);

    if (!src) {
      map.innerHTML =
        '<div class="branch-item">No map available for this location.</div>';
      return;
    }

    map.innerHTML =
      '<iframe src="' +
      src +
      '" loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen></iframe>';
  }

  function buildLocationItem(item, isActive) {
    const div = document.createElement("div");
    div.className = "branch-item" + (isActive ? " active" : "");
    const title = document.createElement("strong");
    title.textContent = item.name;
    div.appendChild(title);

    if (item.address) {
      const address = document.createElement("p");
      address.textContent = item.address;
      div.appendChild(address);
    }

    div.onclick = function () {
      list.querySelectorAll(".branch-item").forEach(function (node) {
        node.classList.remove("active");
      });
      div.classList.add("active");
      renderMap(item);
    };

    return div;
  }

  function getFilteredLocations() {
    const items = Array.isArray(data[currentTab]) ? data[currentTab] : [];
    const value = search.value.toLowerCase().trim();

    if (!value) {
      return items;
    }

    return items.filter(function (item) {
      return [item.name, item.address, item.query]
        .filter(Boolean)
        .some(function (field) {
          return field.toLowerCase().includes(value);
        });
    });
  }

  function loadLocations() {
    const items = getFilteredLocations();
    list.innerHTML = "";

    if (!items.length) {
      map.innerHTML =
        '<div class="branch-item">No locations found for this selection.</div>';
      list.innerHTML =
        '<div class="branch-item">No locations found for this selection.</div>';
      return;
    }

    items.forEach(function (item, index) {
      list.appendChild(buildLocationItem(item, index === 0));
    });

    renderMap(items[0]);
  }

  tabs.forEach(function (tab) {
    if (tab.dataset.tab === currentTab) {
      tab.classList.add("active");
    } else {
      tab.classList.remove("active");
    }

    tab.addEventListener("click", function () {
      currentTab = tab.dataset.tab;
      search.value = "";

      tabs.forEach(function (t) {
        t.classList.remove("active");
      });
      tab.classList.add("active");

      loadLocations();
    });
  });

  loadLocations();
  search.addEventListener("input", loadLocations);
}
