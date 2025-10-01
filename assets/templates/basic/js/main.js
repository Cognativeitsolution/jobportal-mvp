(function ($) {
  ("use strict");

  // ============== Header Hide Click On Body Js Start ========
  $(".header-button").on("click", function () {
    $(".body-overlay").toggleClass("show");
  });
  $(".body-overlay").on("click", function () {
    $(".header-button").trigger("click");
    $(this).removeClass("show");
  });
  // =============== Header Hide Click On Body Js End =========

  // dropdown box js start here ==========



  $(".dropdown-box__wrapper").on("click", function (e) {
    e.stopPropagation();
    $(".dropdown-box__menu").toggleClass("show");
  });
  $(document).on("click", function () {
    $(".dropdown-box__menu").removeClass("show");
  });
  $(".dropdown-box__menu").on("click", function (e) {
    e.stopPropagation();
  });
  // dropdown box js end here ==========



  $(".search-btn").on("click", function () {
    $(".header-search-box").addClass("show");
    $(".body-overlay").addClass("show");
  });
  $(".sidebar-overlay").on("click", function () {
    $(".header-search-box").removeClass("show");
    $(".body-overlay").removeClass("show");
  });
  /*==================== custom dropdown select js ====================*/
  $('.custom--dropdown > .custom--dropdown__selected').on('click', function () {
    $(this).parent().toggleClass('open');
  });
  $('.custom--dropdown > .dropdown-list > .dropdown-list__item').on('click', function () {
    $('.custom--dropdown > .dropdown-list > .dropdown-list__item').removeClass('selected');
    $(this).addClass('selected').parent().parent().removeClass('open').children('.custom--dropdown__selected').html($(this).html());
  });
  $(document).on('keyup', function (evt) {
    if ((evt.keyCode || evt.which) === 27) {
      $('.custom--dropdown').removeClass('open');
    }
  });
  $(document).on('click', function (evt) {
    if ($(evt.target).closest(".custom--dropdown > .custom--dropdown__selected").length === 0) {
      $('.custom--dropdown').removeClass('open');
    }
  });
  /*=============== custom dropdown select js end =================*/

  // ==========================================
  //      Start Document Ready function
  // ==========================================
  $(document).ready(function () {
    // ========================== Header Hide Scroll Bar Js Start =====================
    $(".login-button").on("click", function () {
      $(".login-sidebar").addClass("show-login-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-overlay, .login-sidebar__close").on("click", function () {
      $(".login-sidebar").removeClass("show-login-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    // ========================== Header Hide Scroll Bar Js End =====================

    // user profile sidebar js start
    $(".user-sidebar-button").on("click", function () {
      $(".user-profile-sidebar").addClass("show");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-overlay, .user-profile-sidebar__close-icon").on("click", function () {
      $(".user-profile-sidebar").removeClass("show");
      $(".sidebar-overlay").removeClass("show");
    });
    // user profile sidebar js end

    //  profile dashboard sidebar js start
    $(".profile-dashboard__body-icon").on("click", function () {
      $(".profile-dashboard__sidebar").addClass("show");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-overlay, .close-icon").on("click", function () {
      $(".profile-dashboard__sidebar").removeClass("show");
      $(".sidebar-overlay").removeClass("show");
    });
    // user profile sidebar js end

    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js Start =====================
    $(".dropdown-item").on("click", function () {
      $(this).closest(".dropdown-menu").addClass("d-block");
    });
    // ========================== Small Device Header Menu On Click Dropdown menu collapse Stop Js End =====================

    // ========================== Add Attribute For Bg Image Js Start =====================
    $(".bg-img").css("background", function () {
      var bg = "url(" + $(this).data("background-image") + ")";
      return bg;
    });
    // ========================== Add Attribute For Bg Image Js End =====================

    // ========================== add active class to ul>li top Active current page Js Start =====================
    function dynamicActiveMenuClass(selector) {
      let fileName = window.location.pathname.split("/").reverse()[0];
      selector.find("li").each(function () {
        let anchor = $(this).find("a");
        if ($(anchor).attr("href") == fileName) {
          $(this).addClass("active");
        }
      });
      // if any li has active element add class
      selector.children("li").each(function () {
        if ($(this).find(".active").length) {
          $(this).addClass("active");
        }
      });
      // if no file name return
      if ("" == fileName) {
        selector.find("li").eq(0).addClass("active");
      }
    }
    if ($("ul.sidebar-menu-list").length) {
      dynamicActiveMenuClass($("ul.sidebar-menu-list"));
    }
    // ========================== add active class to ul>li top Active current page Js End =====================

    // dashboard sidebar js start
    $(".dashboard-body__bar-icon").on("click", function () {
      $(".sidebar-menu").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-overlay, .sidebar-menu__close").on("click", function () {
      $(".sidebar-menu").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    // dashboard sidebar js end

    // ================== Password Show Hide Js Start ==========
    $(".toggle-password").on("click", function () {
      $(this).toggleClass(" fa-eye");
      var input = $($(this).attr("id"));
      if (input.attr("type") == "password") {
        input.attr("type", "text");
      } else {
        input.attr("type", "password");
      }
    });
    // =============== Password Show Hide Js End =================

    // tooltip 
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))

    // ========================= Slick Slider Js Start ==============
    $(".content-wrapper").slick({
      dots: true,
      infinite: false,
      speed: 300,
      slidesToShow: 1,
      slidesToScroll: 1,

      prevArrow:
        '<button type="button" class="slick-prev"> <i class="las la-angle-left"></i> </button>',
      nextArrow:
        '<button type="button" class="slick-next"> <i class="las la-angle-right"></i>  </button>',
      responsive: [
        {
          breakpoint: 991,
          settings: {
            arrows: false,
            slidesToShow: 1,
          },
        },
        {
          breakpoint: 464,
          settings: {
            arrows: false,
            slidesToShow: 1,
          },
        },
      ],
    });
    // ========================= Slick Slider Js End ===================

    // ========================= Client Slider Js Start ===============
    // window.loadSlickSlider = () => {
    //   let slide = {
    //     dots: false,
    //     arrows: true,
    //     infinite: false,
    //     speed: 300,
    //     slidesToShow: 4,
    //     slidesToScroll: 1,
    //     prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
    //     nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
    //     responsive: [{
    //       breakpoint: 1199,
    //       settings: {
    //         slidesToShow: 3,
    //       }
    //     },
    //     {
    //       breakpoint: 767,
    //       settings: {
    //         slidesToShow: 2
    //       }
    //     },
    //     {
    //       breakpoint: 500,
    //       settings: {
    //         slidesToShow: 1
    //       }
    //     }
    //     ]
    //   }
    //   $('.dashboardSlider').slick(slide);
    // }

    window.loadFeaturedCompaniesSlickSlider = () => {
      let slide = {
        dots: false,
        arrows: true,
        infinite: false,
        speed: 300,
        slidesToShow: 4,
        slidesToScroll: 1,
        prevArrow: '<button type="button" class="slick-prev"><i class="las la-angle-left"></i></button>',
        nextArrow: '<button type="button" class="slick-next"><i class="las la-angle-right"></i></button>',
        responsive: [{
          breakpoint: 1199,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 500,
          settings: {
            slidesToShow: 1
          }
        }
        ]
      }
      $('.featuredCompaniesSlider').slick(slide);
    }

    // ========================= Client Slider Js End ===================
    $('.select2-modal').each(function (index, element) {
      $(element).select2({
        dropdownParent: $(element).closest('.modal'),
      });
    });

    // ========================= Client Slider Js Start ===============
    $('.feature-slider').slick({
      dots: false,
      arrows: true,
      infinite: false,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 1,
      prevArrow: '<button type="button" class="slick-prev"> <i class="las la-angle-left"></i> </button>',
      nextArrow: '<button type="button" class="slick-next"> <i class="las la-angle-right"></i> </button>',
      responsive: [
        {
          breakpoint: 1399,
          settings: {
            slidesToShow: 3,
          }
        },
        {
          breakpoint: 767,
          settings: {
            slidesToShow: 2
          }
        },
        {
          breakpoint: 500,
          settings: {
            slidesToShow: 1
          }
        }
      ]
    });
    // ========================= Client Slider Js End ===================

    // ========================= Client Slider Js Start ===============
    $('.blog-slider').slick({
      dots: false,
      arrows: true,
      infinite: false,
      speed: 300,
      slidesToShow: 3,
      slidesToScroll: 1,
      prevArrow: '<button type="button" class="slick-prev"> <i class="las la-angle-left"></i> </button>',
      nextArrow: '<button type="button" class="slick-next"> <i class="las la-angle-right"></i> </button>',
      responsive: [
        {
          breakpoint: 991,
          settings: {
            slidesToShow: 2,
          }
        },
        {
          breakpoint: 575,
          settings: {
            slidesToShow: 1
          }
        },

      ]
    });
    // ========================= Client Slider Js End ===================

    /*====== mega menu js start here ======*/
    $('.has-mega-menu').click(function (e) {
      e.stopPropagation();
      var $megaMenu = $(this).find('.mega-menu');
      $('.mega-menu').not($megaMenu).removeClass('show');
      $megaMenu.toggleClass('show');
    });
    /*====== mega menu js end here ======*/

    // show more item js 
    $(document).ready(function () {
      $('.feature-item-wrapper').each(function () {
        var $block = $(this);
        var $checkboxes = $block.find('.item-one');
        var $loadMoreButton = $block.find('.load-more-button');
        var itemsToShow = 8;

        function toggleCheckboxesVisibility() {
          $checkboxes.hide().slice(0, itemsToShow).show();
        }

        $loadMoreButton.on('click', function () {
          itemsToShow = (itemsToShow === 8) ? $checkboxes.length : 8;
          $loadMoreButton.text((itemsToShow === 8) ? 'Load More' : 'Show Less');
          toggleCheckboxesVisibility();
        });

        toggleCheckboxesVisibility();
        $loadMoreButton.toggle($checkboxes.length > itemsToShow);
      });
    });

    $(document).ready(function () {
      $('.load-more-button').parent().each(function () {
        var $block = $(this);
        var $checkboxes = $block.find('.filter-block__item');
        var $loadMoreButton = $block.find('.load-more-button');
        var itemsToShow = 4;

        function toggleCheckboxesVisibility() {
          $checkboxes.hide().slice(0, itemsToShow).show();
        }

        $loadMoreButton.on('click', function () {
          itemsToShow = (itemsToShow === 4) ? $checkboxes.length : 4;
          $loadMoreButton.text((itemsToShow === 4) ? 'Load More' : 'Show Less');
          toggleCheckboxesVisibility();
        });

        toggleCheckboxesVisibility();
        $loadMoreButton.toggle($checkboxes.length > itemsToShow);
      });
    });
    // show more item js end 

    // magnifiq popup js 
    var videoItem = $(".play-button");
    if (videoItem) {
      videoItem.magnificPopup({
        type: "iframe",
      });
    };
    // magnifiq popup js end  

    $('.contact-item__button').on('click', function () {
      $('.contact-item__map').toggleClass('map-show');
    })

    // Sidebar Dropdown Menu Start
    $(".has-dropdown > a").click(function () {
      $(".sidebar-submenu").slideUp(200);
      if ($(this).parent().hasClass("active")) {
        $(".has-dropdown").removeClass("active");
        $(this).parent().removeClass("active");
      } else {
        $(".has-dropdown").removeClass("active");
        $(this).next(".sidebar-submenu").slideDown(200);
        $(this).parent().addClass("active");
      }
    });
    // Sidebar Dropdown Menu End=============

    // scrollspy js here ======================
    $('.collection-list__link').on('click', function () {
      $('.collection-list__link').removeClass('active');
      $(this).addClass('active');
    });
    $(function () {
      var offset = 200;

      $('.collection-list__link').on('click', function (e) {
        e.preventDefault();
        $('html, body').animate({ scrollTop: $(this.hash).offset().top - offset });
      });

      $(window).on('scroll', function () {
        var scrollPos = $(document).scrollTop();
        $('.collection-list__link').each(function () {
          var target = $(this.hash);
          var sectionTop = target.offset().top;
          if (sectionTop - offset <= scrollPos && sectionTop + target.outerHeight() > scrollPos) {
            $('.collection-list__link').removeClass('active');
            $(this).addClass('active');
          }
        });
      });
    });


    // header height
    let headerHeight = $('.dashboard-header').height();
    document.documentElement.style.setProperty('--header-h', `${headerHeight}px`);

    // scrollspy js here end======================

    // Sidebar Icon & Overlay js 
    $(".sidebar-filter-icon").on("click", function () {
      $(".filter-sidebar").addClass("show-filter-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".sidebar-filter__close, .sidebar-overlay").on("click", function () {
      $(".filter-sidebar").removeClass("show-filter-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    // Sidebar Icon & Overlay js

    //profile Sidebar Icon & Overlay js
    $(".profile-header-wrapper__icon").on("click", function () {
      $(".profile-sidebar").addClass("show-sidebar");
      $(".sidebar-overlay").addClass("show");
    });
    $(".profile-sidebar__close, .sidebar-overlay").on("click", function () {
      $(".profile-sidebar").removeClass("show-sidebar");
      $(".sidebar-overlay").removeClass("show");
    });
    //profile Sidebar Icon & Overlay js

    // ===================== Sidebar Menu Js End =================

    // ==================== Dashboard User Profile Dropdown Start ==================
    $(".user-info__button").on("click", function () {
      $(".user-info-dropdown").toggleClass("show");
    });
    $(".user-info__button").attr("tabindex", -1).focus();

    $(".user-info__button").on("focusout", function () {
      $(".user-info-dropdown").removeClass("show");
    });
    // ==================== Dashboard User Profile Dropdown End ==================

    // wow js 
    new WOW().init();
    // wow js end 

    // ========================= Odometer Counter Up Js End ==========
    $(".counterup-item").each(function () {
      $(this).isInViewport(function (status) {
        if (status === "entered") {
          for (
            var i = 0;
            i < document.querySelectorAll(".odometer").length;
            i++
          ) {
            var el = document.querySelectorAll(".odometer")[i];
            el.innerHTML = el.getAttribute("data-odometer-final");
          }
        }
      });
    });
    // ========================= Odometer Up Counter Js End =====================
  });
  // ==========================================
  //      End Document Ready function
  // ==========================================

  // ========================= Preloader Js Start =====================
  $(window).on("load", function () {
    $(".preloader-dot-loading").fadeOut();
  });
  // ========================= Preloader Js End=====================

  // // ========================= Header Sticky Js Start ==============
  $(window).on("scroll", function () {
    if ($(window).scrollTop() >= 300) {
      $(".header").addClass("fixed-header");
    } else {
      $(".header").removeClass("fixed-header");
    }
  });
  // // ========================= Header Sticky Js End===================




  // //============================ Scroll To Top Icon Js Start =========
  var btn = $(".scroll-top");

  $(window).scroll(function () {
    if ($(window).scrollTop() > 300) {
      btn.addClass("show");
    } else {
      btn.removeClass("show");
    }
  });

  btn.on("click", function (e) {
    e.preventDefault();
    $("html, body").animate({ scrollTop: 0 }, "300");
  });
})(jQuery);
