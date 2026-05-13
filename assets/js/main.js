
(function ($) {
  'use strict'

  $(document).ready(function () {

    /* =====================
        Hero Slider area
     ======================= */
    let heroSliderWrapper = $('.hero-slider');

    if (heroSliderWrapper.length) {
      let sliderSettings = JSON.parse(heroSliderWrapper.attr('data-settings'));

      let loop = sliderSettings.loop === 'yes';
      let speed = parseInt(sliderSettings.speed) || 500;
      let autoplay = sliderSettings.autoplay === 'yes' ? { delay: speed } : false;

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
    }


    /* =====================
        Vertical Slider area
     ======================= */
    let verticalSliderWrapper = $('.vertical-slider');

    if (verticalSliderWrapper.length) {
      let verticalSettings = JSON.parse(verticalSliderWrapper.attr('data-settings'));

      let verticalLoop = verticalSettings.loop === true;
      let verticalSpeed = parseInt(verticalSettings.speed) || 500;
      let verticalItems = parseInt(verticalSettings.items) || 3;
      let verticalAutoplay = verticalSettings.autoplay === true ? { delay: verticalSpeed } : false;

      var verticalSlider = new Swiper(".vertical-slider", {
        direction: "vertical",
        loop: verticalLoop,
        slidesPerView: verticalItems,
        spaceBetween: 10,
        autoplay: verticalAutoplay,
        speed: verticalSpeed,
        pagination: {
          el: ".vertical-pagination",
          clickable: true,
          renderBullet: function (index, className) {
            return '<span class="' + className + '">' +
              '<span class="vertical-slider-btn-wrap">' +
                '<span></span><span></span><span></span><span></span>' +
              '</span>' +
            '</span>';
          },
        },
      });
    }


  })
})(jQuery);