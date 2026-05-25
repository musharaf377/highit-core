(function ($) {
  "use strict";

  $(document).ready(function () {
    /* =====================
        Hero Slider area
     ======================= */
    let heroSliderWrapper = $(".hero-slider");

    if (heroSliderWrapper.length) {
      let sliderSettings = JSON.parse(heroSliderWrapper.attr("data-settings"));

      let loop = sliderSettings.loop === "yes";
      let speed = parseInt(sliderSettings.speed) || 500;
      let autoplay =
        sliderSettings.autoplay === "yes" ? { delay: speed } : false;

      var thumb = new Swiper(".hero-slider-thumb", {
        loop: loop,
        spaceBetween: 10,
        slidesPerView: "auto",
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
    var $vertSlider = $(".vertical-slider");

    if ($vertSlider.length) {
      var vsSettings = JSON.parse($vertSlider.attr("data-settings"));
      var vsDuration = (parseInt(vsSettings.speed) || 300) / 1000;

      var vsEl      = $vertSlider[0];
      var vsAreaEl  = vsEl.closest(".vertical-slider-area") || vsEl.parentElement;
      var vsSlides  = Array.from(vsEl.querySelectorAll(".vs-track .vs-slide"));
      var vsTotal   = vsSlides.length;
      var vsCurrent = 0;

      if (vsTotal >= 2) {
        var vsPagEl = vsEl.querySelector(".vertical-pagination");

        function vsSync(idx) {
          if (!vsPagEl) return;
          vsPagEl.querySelectorAll(".swiper-pagination-bullet").forEach(function (b, i) {
            b.classList.toggle("swiper-pagination-bullet-active", i === idx);
          });
        }

        // ── Initial positions: slide 0 on top, rest below by z-index ────────────
        vsSlides.forEach(function (s, i) {
          gsap.set(s, { zIndex: vsTotal - i });
          gsap.set(s.querySelector(".vertical-slider-content"), { height: "100%" });
        });

        // ── Revealer timeline: current slide's content shrinks to reveal next ──
        var vsTL = gsap.timeline();
        for (var i = 0; i < vsTotal - 1; i++) {
          vsTL.to(vsSlides[i].querySelector(".vertical-slider-content"), {
            height: "0%",
            duration: 1,
            ease: "none",
          }, i);
        }

        // ── Pin + scrub ───────────────────────────────────────────────────────
        var vsST = ScrollTrigger.create({
          trigger:             vsAreaEl,
          start:               "top top",
          end:                 "+=" + (vsTotal - 1) * window.innerHeight,
          pin:                 true,
          anticipatePin:       1,
          invalidateOnRefresh: true,
          animation:           vsTL,
          scrub:               vsDuration,
          onUpdate: function (self) {
            var idx = Math.round(self.progress * (vsTotal - 1));
            if (idx !== vsCurrent) {
              vsCurrent = idx;
              vsSync(idx);
            }
          },
        });

        // ── Wheel: exactly one slide per scroll ──────────────────────────────
        var vsWheelBusy = false;

        window.addEventListener("wheel", function (e) {
          if (!vsST.isActive) return;

          var goForward = e.deltaY > 0;
          if (goForward && vsCurrent >= vsTotal - 1) return;
          if (!goForward && vsCurrent <= 0) return;

          e.preventDefault();
          if (vsWheelBusy) return;

          vsWheelBusy = true;
          var nextIdx = goForward ? vsCurrent + 1 : vsCurrent - 1;
          var targetScroll = vsST.start + (nextIdx / (vsTotal - 1)) * (vsST.end - vsST.start);
          window.scrollTo(0, targetScroll);

          setTimeout(function () {
            vsWheelBusy = false;
          }, vsDuration * 1000 + 100);
        }, { passive: false });

        // ── Pagination ────────────────────────────────────────────────────────
        if (vsPagEl) {
          vsSlides.forEach(function (_, i) {
            var b = document.createElement("span");
            b.className = "swiper-pagination-bullet" + (i === 0 ? " swiper-pagination-bullet-active" : "");
            b.innerHTML = '<span class="vertical-slider-btn-wrap"><span></span><span></span><span></span><span></span></span>';
            b.addEventListener("click", function () {
              var targetScroll = vsST.start + (i / (vsTotal - 1)) * (vsST.end - vsST.start);
              window.scrollTo(0, targetScroll);
            });
            vsPagEl.appendChild(b);
          });
        }

        vsSync(0);
      }
    }

    /* =====================
       Image Lightbox
     ======================= */
    var hltLightbox = (function () {
      var $lb = null, $img = null, gallery = [], current = 0;

      function showImage(idx) {
        current = (idx + gallery.length) % gallery.length;
        $img.attr({ src: gallery[current].src, alt: gallery[current].alt });
      }

      function close() {
        $lb.removeClass('is-open');
        $('body').removeClass('hlt-lightbox-open');
        setTimeout(function () { $img.attr('src', ''); }, 320);
      }

      function init() {
        if ($lb) return;
        $('body').append(
          '<div id="hlt-lightbox" class="hlt-lightbox" role="dialog" aria-modal="true" aria-label="Image gallery">' +
            '<button class="hlt-lightbox-close" aria-label="Close">&times;</button>' +
            '<button class="hlt-lightbox-prev" aria-label="Previous image">&#8249;</button>' +
            '<button class="hlt-lightbox-next" aria-label="Next image">&#8250;</button>' +
            '<div class="hlt-lightbox-inner"><img class="hlt-lightbox-img" src="" alt="" /></div>' +
          '</div>'
        );
        $lb  = $('#hlt-lightbox');
        $img = $lb.find('.hlt-lightbox-img');

        $lb.find('.hlt-lightbox-close').on('click', close);
        $lb.on('click', function (e) { if ($(e.target).is($lb)) close(); });
        $lb.find('.hlt-lightbox-prev').on('click', function () { showImage(current - 1); });
        $lb.find('.hlt-lightbox-next').on('click', function () { showImage(current + 1); });

        $(document).on('keydown.hltLightbox', function (e) {
          if (!$lb || !$lb.hasClass('is-open')) return;
          if (e.key === 'Escape')     close();
          if (e.key === 'ArrowLeft')  showImage(current - 1);
          if (e.key === 'ArrowRight') showImage(current + 1);
        });
      }

      return {
        open: function (items, startIdx) {
          init();
          gallery = items;
          showImage(startIdx);
          $lb.find('.hlt-lightbox-prev, .hlt-lightbox-next').toggle(gallery.length > 1);
          $lb.addClass('is-open');
          $('body').addClass('hlt-lightbox-open');
        }
      };
    }());

    $(document).on('click', '.portfolio-item[data-gallery-src]', function () {
      var $item  = $(this);
      var group  = $item.data('gallery-group');
      var $group = $('[data-gallery-group="' + group + '"]');
      var items  = $group.map(function () {
        return { src: $(this).data('gallery-src'), alt: $(this).find('img').attr('alt') || '' };
      }).get();
      hltLightbox.open(items, $group.index($item));
    });

    /* =====================
        Portfolio Tab Widget (AJAX)
     ======================= */
    var hltCfg = window.highltCore || {};
    var hltI18n = hltCfg.i18n || {};
    var loadingLabel = hltI18n.loading || "Loading…";
    var errorLabel = hltI18n.error || "Failed to load. Please try again.";

    function hltLoadingMarkup() {
      return (
        '<div class="portfolio-tab-loading" role="status" aria-live="polite">' +
        '<span class="portfolio-tab-spinner" aria-hidden="true"></span>' +
        '<span class="portfolio-tab-loading-text">' + loadingLabel + "</span>" +
        "</div>"
      );
    }

    function hltErrorMarkup(msg) {
      return '<p class="portfolio-error" role="alert">' + (msg || errorLabel) + "</p>";
    }

    function hltLoadTab($area, $pane, settings) {
      // Cache: skip the request if this pane has already loaded successfully.
      if ($pane.data("hltLoaded")) {
        return;
      }

      var tab = $pane.data("tab");
      if (!tab || !hltCfg.ajax_url || !hltCfg.nonce) {
        $pane.html(hltErrorMarkup());
        return;
      }

      // Abort any in-flight request for this pane to avoid stale injections.
      var prev = $pane.data("hltXhr");
      if (prev && prev.readyState !== 4) {
        prev.abort();
      }

      $pane.html(hltLoadingMarkup());

      var payload = $.extend({
        action: "highlt_portfolio_tab",
        nonce: hltCfg.nonce,
        tab: tab,
      }, settings || {});

      var xhr = $.ajax({
        url: hltCfg.ajax_url,
        method: "POST",
        dataType: "json",
        data: payload,
      })
        .done(function (response) {
          if (response && response.success && response.data && typeof response.data.html === "string") {
            $pane.html(response.data.html);
            $pane.data("hltLoaded", true);
            hltInitFade($pane[0]);
            hltInitGalleryFade($pane[0]);
          } else {
            var msg = response && response.data && response.data.message ? response.data.message : null;
            $pane.html(hltErrorMarkup(msg));
          }
        })
        .fail(function (jqXHR, textStatus) {
          if (textStatus === "abort") return;
          $pane.html(hltErrorMarkup());
        });

      $pane.data("hltXhr", xhr);
    }

    $(".portfolio-tab-area").each(function () {
      var $area = $(this);
      var $buttons = $area.find(".tabs-nav .tab-btn");
      var $panes = $area.find(".content-area .tab-content");

      if (!$buttons.length || !$panes.length) return;

      var settings = {};
      var rawSettings = $area.attr("data-settings");
      if (rawSettings) {
        try { settings = JSON.parse(rawSettings); } catch (err) { settings = {}; }
      }

      // Initial load for the active tab.
      var $activePane = $panes.filter(".active").first();
      if ($activePane.length) {
        hltLoadTab($area, $activePane, settings);
      }

      $buttons.on("click", function (e) {
        e.preventDefault();

        var target = $(this).data("target");
        if (!target) return;

        $buttons.removeClass("active");
        $(this).addClass("active");

        // Pause any playing videos before switching panes.
        $panes.find("video").each(function () {
          if (!this.paused) this.pause();
        });

        $panes.removeClass("active");
        var $next = $area.find("#" + target);
        $next.addClass("active");

        hltLoadTab($area, $next, settings);
      });
    });


    // Hero sticky animation pin
    const stickyHero = document.querySelector('.hero-sticky-animation');

    if (stickyHero) {
      ScrollTrigger.create({
        trigger: stickyHero,
        start: 'top top',
        end: () => '+=' + stickyHero.nextElementSibling.offsetHeight, // pins for the height of the content below
        pin: true,
        pinSpacing: false,
        anticipatePin: 1,
        invalidateOnRefresh: true,
      });
    }

    // Fade Animations on Scroll
    function hltInitFade(scope) {
      gsap.utils.toArray(".highlt-fade-animation", scope).forEach(function (el) {
        gsap.from(el, {
          opacity: 0,
          y: 100,
          duration: 1.5,
          ease: "power3.out",
          clearProps: "all",
          scrollTrigger: {
            trigger: el,
            start: "top 80%",
            toggleActions: "play none none none",
          },
        });
      });
    }

    hltInitFade(document);

    // Gallery fade animation with stagger
    function hltInitGalleryFade(scope) {
      gsap.utils.toArray(".highlt-gallery-fade", scope).forEach(function (container) {
        var children = container.querySelectorAll(":scope > div");
        gsap.from(children, {
          opacity: 0,
          y: 15,
          duration: 1,
          ease: "power2.out",
          stagger: 0.18,
          scrollTrigger: {
            trigger: container,
            start: "top 85%",
            toggleActions: "play none none none",
          },
        });
      });
    }

    hltInitGalleryFade(document);



  });
})(jQuery);
