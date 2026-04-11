{{-- @php
    $home_page_variant = $home_page ?? get_static_option('home_page_variant');
    $home_page19_color_con = $home_page_variant == '19' ? '' :  'footer-top';
@endphp
@if (!in_array(Route::currentRouteName(), ['frontend.course.lesson', 'frontend.course.lesson.start']))
<footer class="footer-area home-variant-{{$home_page_variant}}
@if ((request()->routeIs('homepage') || request()->routeIs('frontend.homepage.demo')) && $home_page_variant == '17' && filter_static_option_value('home_page_call_to_action_section_status', $static_field_data))
   has-top-padding
@endif
@if ($home_page_variant === '21')
 home-21 home-21-section-bg footer-color-five
 @elseif($home_page_variant == '19')
 footer-bg footer-color-three
@endif
">
@if (App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('footer', ['column' => true]))
<div class="{{$home_page19_color_con}} padding-top-90 padding-bottom-65">
    <div class="container">
        <div class="row">
            {!! App\WidgetsBuilder\WidgetBuilderSetup::render_frontend_sidebar('footer',['column' => true]) !!}
        </div>
    </div>
</div>
@endif
<div class="copyright-area copyright-bg">
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="copyright-item">
                <div class="copyright-area-inner">
                    {!! get_footer_copyright_text() !!}
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</footer>
@if (preg_match('/(xgenious)/', url('/')))
<div class="buy-now-wrap">
<ul class="buy-list">
    <li><a target="_blank"href="https://xgenious.com/laravel/nexelit/doc/" data-container="body" data-toggle="popover" data-placement="left" data-content="{{__('Documentation')}}"><i class="far fa-file-alt"></i></a></li>
    <li><a target="_blank"href="https://1.envato.market/OXNPP"><i class="fas fa-shopping-cart"></i></a></li>
    <li><a target="_blank"href="https://xgenious51.freshdesk.com/"><i class="fas fa-headset"></i></a></li>
</ul>
</div>
@endif
<div class="back-to-top">
<span class="back-top">
<i class="fas fa-angle-up"></i>
</span>
</div>

@include('frontend.partials.popup-structure')
@endif
<!-- load all script -->
<script src="{{asset('assets/frontend/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/dynamic-script.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.magnific-popup.js')}}"></script>
<script src="{{asset('assets/frontend/js/imagesloaded.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.waypoints.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.counterup.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/wow.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jQuery.rProgressbar.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.mb.YTPlayer.js')}}"></script>
<script src="{{asset('assets/frontend/js/jquery.nicescroll.min.js')}}"></script>
<script src="{{asset('assets/frontend/js/slick.js')}}"></script>
<script src="{{asset('assets/frontend/js/main.js')}}"></script>
@if (\Route::currentRouteName() === 'frontend.products')
<script src="{{asset('assets/frontend/js/jquery-ui.js')}}"></script>
@endif
<script src="{{asset('assets/frontend/js/toastr.min.js')}}"></script>

<x-frontend.others.advertisement-script/>
@if (request()->routeIs('homepage') || request()->routeIs('frontend.homepage.demo'))
@include('frontend.partials.popup-jspart')
@include('frontend.partials.gdpr-cookie')
@endif

@include('frontend.partials.twakto')
@include('frontend.partials.google-captcha')
@include('frontend.partials.inline-script')
@include('frontend.partials.product-ajax-js')
@yield('scripts')



</body>
</html> --}}
<div class="empty-height-50"></div>
<footer class="footer ">
    <div class="container-fluid mx-auto">
        <div class="footer-wrapper" data-aos="fade-up" data-aos-duration="2000">
            <a style="display: inline-block;" href="{{url('/')}}" data-aos="fade-up" data-aos-duration="2000">
                @if(!empty(filter_static_option_value('site_logo',$global_static_field_data)))
                    {!! render_image_markup_by_attachment_id(filter_static_option_value('site_logo',$global_static_field_data)) !!}
                @else
                    <h2 class="site-title">{{filter_static_option_value('site_'.$user_select_lang_slug.'_title',$global_static_field_data)}}</h2>
                @endif
            </a>
        </div>
        <div class="footer-wrap">
            <div style="opacity: 1; transform: none; grid-column: span 3 / span 3;">
                <h3 class="text-[#012C60] font-bold leading-4 text-base mb-4" data-aos="fade-up"
                    data-aos-duration="2000">Address</h3>
                <div data-aos="fade-up" data-aos-duration="2000"
                    class="text-sm font-extralight sm:text-base sm:leading-[23px] text-[#637D92]">
                    <p class="font-light">Uttara Bank
                        PLC Dhaka 1212</p>
                    <p class="font-light mt-2">24/7 Call
                        Center <a class="text-[#012C60] font-medium &quot;" href="tel:16645">16645</a></p>
                </div>
            </div>
            <div class="footer-menu" style="opacity: 1; transform: none;">
                <div data-aos="fade-up" data-aos-duration="3000">
                    <!-- <h3 class="text-[#012C60] font-bold leading-4 text-base mb-4">Important Menu</h3> -->
                    <ul class="space-y-2 p-0">
                        <li>
                            <a aria-label="Contact Us"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">Contact
                                Us</a>
                        </li>
                        <li>
                            <a aria-label="Career"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">Career</a>
                        </li>
                        <li>
                            <a aria-label="Financial Literacy"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">Financial
                                Literacy</a>
                        </li>
                        <li>
                            <a aria-label="CSR"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">CSR</a>
                        </li>
                    </ul>
                </div>
                <div data-aos="fade-up" data-aos-duration="4000">
                    <!-- <h3 class="text-[#012C60] font-bold leading-4 text-base mb-4"> Footer Menu</h3> -->
                    <ul class="space-y-2 p-0">
                        <li>
                            <a aria-label="About Us"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">About Us</a>
                        </li>
                        <li>
                            <a aria-label="Investor Relations"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">Investor Relations</a>
                        </li>
                        <li>
                            <a aria-label="Exchange Rates"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">Exchange Rates</a>
                        </li>
                        <li>
                            <a aria-label="Risk Based Capital"
                                class="text-[#637D92] sm:font-light hover:underline text-sm font-extralight sm:text-base sm:leading-[23px]"
                                href="#">Risk Based Capital</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div style="opacity: 1; transform: none;">
                <div class="footer-social" data-aos="fade-up" data-aos-duration="5000">
                    {{-- <a target="_blank" aria-label="social icon 1" href="https://www.facebook.com/UttaraBankPLC/">
                        <img alt="social icon" loading="lazy" width="24" height="24" decoding="async"
                            data-nimg="1" class style="color:transparent"
                            src="https://brackweb.s3.ap-southeast-1.amazonaws.com/uploads/all/facebook683e92811d513.png">
                    </a>
                    <a target="_blank" aria-label="social icon 4" href="https://www.youtube.com/@uttarabankbdplc">
                        <img alt="social icon" loading="lazy" width="24" height="24" decoding="async"
                            data-nimg="1" class style="color:transparent"
                            src="https://brackweb.s3.ap-southeast-1.amazonaws.com/uploads/all/youtube683e9326e1f06.png">
                    </a> --}}
                    @foreach($all_social_item as $data)
                                    <li><a href="{{$data->url}}" rel="canonical"><i class="{{$data->icon}}"></i></a></li>
                                @endforeach
                </div>
                <div class="footer-subscribe" data-aos="fade-up" data-aos-duration="5000">
                    <h3>Subscribe Newsletter</h3>
                    <form>
                        <input id="email" type="email" placeholder="Enter your email address">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none"
                                viewBox="0 0 67 67">
                                <circle cx="33.209" cy="33.518" r="28.084" fill="#008649"></circle>
                                <circle cx="33.209" cy="33.518" r="30.584" stroke="#008649"
                                    stroke-opacity="0.2" stroke-width="5"></circle>
                                <g clip-path="url(#footerRightCircle_svg__a)">
                                    <path fill="#fff"
                                        d="m44.754 33.792-6.884-6.938a.814.814 0 0 0-1.155 1.145l5.508 5.554H22.244a.813.813 0 0 0-.814.815c0 .45.363.814.814.814h19.979l-5.508 5.554a.814.814 0 0 0 1.155 1.146l6.884-6.94a.82.82 0 0 0 0-1.15">
                                    </path>
                                </g>
                                <defs>
                                    <clippath id="footerRightCircle_svg__a">
                                        <path fill="#fff" d="M21.43 22.585h23.559v23.559h-23.56z"></path>
                                    </clippath>
                                </defs>
                            </svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class=" py-2">
        <hr>
        <p class="text-[#012C60] text-center font-light md:text-base">{!! get_footer_copyright_text() !!}</p>
    </div>
</footer>

<button id="backToTop" class="back-to-top" title="Go to top">
    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path d="M12 19V5M12 5L5 12M12 5L19 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" />
    </svg>
</button>


</div>

</div>
<div class="aceibility-switcher" id="choose_color">
    <a href="#" class="picker_close" data-toggle="tooltip" data-placement="top" title data-original-title><i
            class="qmenu-btn fas fa-solid fa-wheelchair"></i></a>

    <!-- <h4 class="accsstitle">Accessibility Menu</h4> -->
    <div class="animations">
        <h5 class="accsssubtitle">Font size</h5>
        <a href="javascript:increaseFontSize();" id="increaseFontSize" class="active"><i class="fas fa-font"></i>
            +</a>
        <a href="javascript:decreaseFontSize();" id="decreaseFontSize" class="active"><i class="fas fa-font"></i> -
        </a>
        <br> <br>
        <h5 class="accsssubtitle">Text Space/Line
            Height</h5>
        <a href="javascript:increaseTextspSize();" id="increaseTextspSize" class="active"><i
                class="fas fa-text-width"></i> +</a>
        <a href="javascript:increaseLineSize();" id="increaseLineSize" class="active"><i
                class="fas fa-text-height"></i>
            +</a>
    </div>

    <div class="header-footer">
        <div class="half">
            <h5 class="accsssubtitle">Others</h5>
            <div class="styled-selectt">
                <ul>
                    <li id="h-one"><a id="ahrfHighlight" href="#"><input type="checkbox"><i>
                            </i> Highlight Links</a></li>
                    <li id="h-two"><a id="invertImages" href="#"><input type="checkbox"><i></i>
                            Inverted Colors</a></li>
                    <li id="h-three"><a id="Monochrome" href="#"><input type="checkbox"><i></i>
                            Monochrome</a></li>
                    <li id="h-three"><a id="Dyslexia" href="#"><input type="checkbox"><i></i>
                            Dyslexia
                            Friendly</a></li>
                    <li id="h-three"><a id="bigCursor" href="#"><input type="checkbox"><i></i> Big
                            Cursor</a></li>
                    <li id="h-three"><a id="readingguide" href="#"><input type="checkbox"><i></i>
                            Reading Guide</a></li>
                    <li id="h-three"></li>
                </ul>
            </div>
        </div>

        <hr>
        <a id="screenreader" target="_blank" href="#">Download
            screen reader</a>
        <a href="#" id="accecesbilitclean">Clear All</a>

    </div>

</div>

<!-- Javascript files-->
<script src="{{ asset('assets/frontend/assets/js/jquery-3.6.0.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.js"
    integrity="sha512-Rd5Gf5A6chsunOJte+gKWyECMqkG8MgBYD1u80LOOJBfl6ka9CtatRrD4P0P5Q5V/z/ecvOCSYC8tLoWNrCpPg=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="{{ asset('assets/frontend/assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/jquery.cookie.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/jquery.waypoints.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/owl.carousel.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/owl.carousel2.thumbs.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/jquery.parallax-1.1.3.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/bootstrap-select.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/jquery.scrollTo.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/front.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/waypoint.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/custom_v2.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/isInViewport.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/active.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/modernizr.min.js') }}"></script>
<script src="{{ asset('assets/frontend/assets/js/jquery.touchSwipe.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>

<script src="{{ asset('assets/frontend/assets/js/script-custom.js') }}"></script>


<script>
    var isiOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream;
    var android = /Android/.test(navigator.userAgent) && !window.MSStream;

    if (isiOS) {
        // alert('ios');
        $("#appspopupApple").show();
        $("#appspopupAndroid").hide();

        $("#appspopupApple").css("display", "block");
        $("#appspopupAndroid").css("display", "none");

        $('#appshideandApple').click(function() {
            $("#appspopupApple").fadeOut();
        });


    } else if (android) {
        // alert('android');
        $("#appspopupApple").hide();
        $("#appspopupAndroid").show();

        $("#appspopupApple").css("display", "none");
        $("#appspopupAndroid").css("display", "block");

        $('#appshideandAndroid').click(function() {
            $("#appspopupAndroid").fadeOut();
        });
    } else {
        // alert('other');
        $("#appspopupApple").hide();
        $("#appspopupAndroid").hide();

        $("#appspopupApple").css("display", "none");
        $("#appspopupAndroid").css("display", "none");

        $('#appshideandAndroid').click(function() {
            $("#appspopupAndroid").fadeOut();
        });
    }
</script>

<script>
    jQuery(document).ready(function() {
        var currentUrl = window.location.href;
        var currentUrlArray = currentUrl.split('#');
        var hashLink = "#" + currentUrlArray[1];
        if (hashLink == "#SubordinatedBond") {
            var id = $("#SubordinatedBond");
            $('html, body').animate({
                scrollTop: $(id).offset().top - 150
            }, 1000);
        }

        $("#about-menu #responsive-bar").on("mouseover", function() {
            $("#about-menu .container-fluid").toggle("slow");
        });

        function aboutMenuAnimation(d) {
            if (d === "down") {

                $("#about-menu").css({
                    "position": "fixed",
                    "top": "20%",
                    "left": "-10px",
                    "z-index": "9999",
                }).animate({
                    left: 0,
                }, 1000, function() {
                    $this.show('slow');
                });
                $("#c-profile, #c-report, #c-responsibility, #c-creditRating").removeClass('col-md-2');
                $("#about-menu .radius-icon").css({
                    margin: 0,
                });
                $(".about-menu-col").addClass('max-width');
                $(".about-menu-col").css({
                    "margin-left": "0",
                });
                $("#about-menu .container-fluid").hide("slow");
                $("#about-menu #responsive-bar").show('slow');

                $(".about-nav p").hide("slow");
            }
            if (d === "up") {
                $(".about-menu-col").removeClass('max-width');
                $("#about-menu .radius-icon").removeAttr("style");
                $("#about-menu").removeAttr("style");
                $(".about-menu-col").css({
                    "margin": "0 auto",
                });
                $(".about-nav p").show("slow");
                $("#c-profile, #c-report, #c-responsibility, #c-creditRating").addClass('col-md-2');
                $("#about-menu #responsive-bar").hide('slow');
                $("#about-menu .container-fluid").show("slow");

            }
        }
        if (document.getElementById("about-page")) {
            var waypoint = new Waypoint({
                element: document.getElementById('atAglance'),
                handler: function(direction) {
                    console.log(direction);
                    aboutMenuAnimation(direction);
                }
            });
        }

        if (document.getElementById("sme-page")) {
            var waypoint = new Waypoint({
                element: document.getElementById('corporateVisionMissionValues'),
                handler: function(direction) {
                    console.log(direction);
                    aboutMenuAnimation(direction);
                }
            });
        }

        if (document.getElementById("retail-page")) {
            var waypoint = new Waypoint({
                element: document.getElementById('loan-products'),
                handler: function(direction) {
                    console.log(direction);
                    aboutMenuAnimation(direction);
                }
            });
        }

        if (document.getElementById("career-page")) {
            var waypoint = new Waypoint({
                element: document.getElementById('corporateVisionMissionValues'),
                handler: function(direction) {
                    console.log(direction);
                    aboutMenuAnimation(direction);
                }
            });
        }


        function hashLinkVisitHomepage(hash) {

            var currentUrl = window.location.href;
            var currentUrlArray = currentUrl.split('#');
            var hashLink = "#" + currentUrlArray[1];
            if (hash != "") {
                hashLink = hash;
            }
            var offsetTop = $(hashLink).offset().top - $(".header").height();
            $('html, body').animate({
                scrollTop: offsetTop
            }, 500);
            $(hashLink).slideDown("slow");
            return false;
        }

        // on page load routes
        var currentUrl = window.location.href;
        var currentUrlArray = currentUrl.split('#');
        var hashLink = "#" + currentUrlArray[1];
        $("header .nav-item").on('click', function() {
            var url = $(this).find('a:first').attr('href');
            var urlArray = url.split('#');
            var hashLink = "#" + urlArray[1];
            if (hashLink != "#undefined") {
                $(".nav-item").removeClass('active');
                $(this).addClass('active');
            }
        });
        $("header .nav-item a").on('click', function(event) {
            hashLinkVisitHomepage(this.hash);
        });
    });
</script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init({
        disable: false,
        startEvent: 'DOMContentLoaded',
        initClassName: 'aos-init',
        animatedClassName: 'aos-animate',
        useClassNames: false,
        delay: 500,
        duration: 2000,
        easing: 'ease',
        once: false,
        mirror: false,
        anchorPlacement: 'top-bottom',
    });
    AOS.init();
    $(window).on("load", function() {

        var hash = window.location.hash;

        var invalidHashes = ['#retail', '#sme', '#wholesale'];

        if (!invalidHashes.includes(hash)) {
            $("#whats-news-3").modal("show");
        }

    });
</script>

<script>
    // News Letter Js


    let news = [
        "Mr. Khandaker Ali Samnoon, Deputy Managing Director of Uttara Bank PLC has inaugurated the 50th Sub Branch of the Bank",
        "Uttara Bank launches new digital banking services for customers",
        "Uttara Bank introduces SME loan support program for entrepreneurs",
        "Visit https://www.uttarabank-bd.com/ for more latest banking news"
    ];

    let newsIndex = 0;
    let charIndex = 0;

    function typeNews() {

        let current = news[newsIndex];

        if (charIndex < current.length) {

            document.getElementById("typing").innerHTML += current.charAt(charIndex);

            charIndex++;

            setTimeout(typeNews, 40);

        } else {

            setTimeout(nextNews, 3000);

        }
    }

    function nextNews() {

        charIndex = 0;

        newsIndex++;

        if (newsIndex >= news.length) {
            newsIndex = 0;
        }

        document.getElementById("typing").innerHTML = "";

        typeNews();
    }

    typeNews();
</script>
<script>
    const langButtons = document.querySelectorAll(".lang button");

    langButtons.forEach(btn => {

        btn.addEventListener("click", function() {

            langButtons.forEach(b => b.classList.remove("active"));

            this.classList.add("active");

        });

    });


    var swiper = new Swiper(".moreSlider", {
        slidesPerView: 5,
        // centeredSlides: true,
        spaceBetween: 30,
        loop: true,
        speed: 800,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        breakpoints: {

            320: {
                slidesPerView: 1,
                spaceBetween: 30
            },

            768: {
                slidesPerView: 2,
                spaceBetween: 30
            },
            991: {
                slidesPerView: 3,
                spaceBetween: 30
            },
            1200: {
                slidesPerView: 4,
                spaceBetween: 30
            }
        },
        autoplay: {
            delay: 3000,
            disableOnInteraction: false
        }

    });
</script>
</div>
</body>
</html> 