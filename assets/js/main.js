
(function ($) {
  'use strict'

  $(document).ready(function () {

    /* =====================
        Hero Slider area
     ======================= */
    let heroSliderWrapper = $('.hero-slider');

    let heroSliderSetting = heroSliderWrapper.attr('data-settings');
    let sliderSettings = JSON.parse(heroSliderSetting);

    let loop = sliderSettings.loop;
    let autoplay = sliderSettings.autoplay;
    let speed = sliderSettings.speed;

    var thumb = new Swiper(".hero-slider-thumb", {
      loop: loop,
      spaceBetween: 10,
      slidesPerView: 2,
      freeMode: true,
      watchSlidesProgress: true,
    });

    var heroSlider = new Swiper(".hero-slider", {
      loop: loop,
      spaceBetween: 10,
      autoplay: autoplay,
      speed: speed,
      thumbs: {
        swiper: thumb,
      },
    });
















    

    /* =====================
        Testimonial Slider area
     ======================= */
    let testimonialSliderWrapper = $('.testimonial-slider');

    let testimonialSliderSetting = testimonialSliderWrapper.attr('data-settings');
    let testimonialSliderSettings = JSON.parse(testimonialSliderSetting);

    let testimonialLoop = testimonialSliderSettings.loop;
    let testimonialAutoplay = testimonialSliderSettings.autoplay;
    let testimonialSpeed = testimonialSliderSettings.speed;

    var testimonialSlider = new Swiper(".testimonial-slider", {
      loop: testimonialLoop,
      spaceBetween: 40,
      slidesPerView: 1,
      autoplay: testimonialAutoplay,
      speed: testimonialSpeed,
      navigation: {
        nextEl: ".nav-next",
        prevEl: ".nav-prev",
      },
      breakpoints: {
        0: {
          slidesPerView: 1,
          spaceBetween: 50,
        },
        768: {
          slidesPerView: 2,
          spaceBetween: 60,
        },
        1200: {
          slidesPerView: 3,
          spaceBetween: 70,
          centeredSlides: true,
          initialSlide: 1,
        },
      },

    });



  })
})(jQuery);