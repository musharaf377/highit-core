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
        Vertical Slider area (GSAP ScrollTrigger pin)
     ======================= */
    var $vertSlider = $(".vertical-slider");

    if ($vertSlider.length) {
      var vsSettings = JSON.parse($vertSlider.attr("data-settings"));
      var vsDuration = (parseInt(vsSettings.speed) || 800) / 1000;

      var vsEl     = $vertSlider[0];
      var vsAreaEl = vsEl.closest(".vertical-slider-area") || vsEl.parentElement;
      var vsSlides = Array.from(vsEl.querySelectorAll(".vs-track .vs-slide"));
      var vsTotal  = vsSlides.length;
      var vsCurrent = 0;
      var vsBusy    = false;

      if (vsTotal >= 2) {
        var vsPagEl = vsEl.querySelector(".vertical-pagination");

        // ── Helpers ──────────────────────────────────────────────────────────
        function vsSync(idx) {
          if (!vsPagEl) return;
          vsPagEl.querySelectorAll(".swiper-pagination-bullet").forEach(function (b, i) {
            b.classList.toggle("swiper-pagination-bullet-active", i === idx);
          });
        }

        function vsResetPositions(idx) {
          vsSlides.forEach(function (s, i) {
            gsap.set(s, { zIndex: i + 1, yPercent: i <= idx ? 0 : 100, scale: 1 });
          });
        }

        // Initial stack: slide 0 visible, rest waiting below
        vsSlides.forEach(function (s, i) {
          gsap.set(s, { yPercent: i === 0 ? 0 : 100, scale: 1, zIndex: i + 1 });
        });

        // ── Navigation ──────────────────────────────────────────────────────
        function vsNavigate(direction, targetIndex) {
          var next = targetIndex !== undefined
            ? targetIndex
            : direction === "forward" ? vsCurrent + 1 : vsCurrent - 1;

          if (next >= vsTotal) next = vsTotal - 1;
          if (next < 0)        next = 0;
          if (next === vsCurrent || vsBusy) return;

          vsBusy = true;
          var fromSlide = vsSlides[vsCurrent];
          var toSlide   = vsSlides[next];

          vsSync(next);

          function onDone() {
            vsCurrent = next;
            vsResetPositions(vsCurrent);
            vsBusy = false;
          }

          if (direction === "forward") {
            gsap.fromTo(toSlide,
              { yPercent: 100, scale: 1.07, zIndex: vsTotal + 1 },
              { yPercent: 0, scale: 1, duration: vsDuration, ease: "power2.out", onComplete: onDone }
            );
            gsap.to(fromSlide, { yPercent: -8, duration: vsDuration, ease: "power2.out" });
          } else {
            gsap.set(fromSlide, { zIndex: vsTotal + 1 });
            gsap.set(toSlide,   { yPercent: 0, zIndex: vsTotal });
            gsap.to(fromSlide,  { yPercent: 100, duration: vsDuration, ease: "power2.out", onComplete: onDone });
            gsap.fromTo(toSlide, { scale: 1.07 }, { scale: 1, duration: vsDuration, ease: "power2.out" });
          }
        }

        // ── ScrollTrigger Pin ────────────────────────────────────────────────
        var vsST = ScrollTrigger.create({
          trigger: vsAreaEl,
          start: "top top",
          end: "+=" + (vsTotal - 1) * window.innerHeight,
          pin: true,
          anticipatePin: 1,
          invalidateOnRefresh: true,
          snap: {
            snapTo: 1 / (vsTotal - 1),
            duration: { min: 0.15, max: 0.3 },
            ease: "power2.inOut",
          },
          onUpdate: function (self) {
            var targetIdx = Math.round(self.progress * (vsTotal - 1));
            if (targetIdx !== vsCurrent && !vsBusy) {
              vsNavigate(targetIdx > vsCurrent ? "forward" : "backward", targetIdx);
            }
          },
        });

        // ── Pagination ──────────────────────────────────────────────────────
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
        Portfolio Tab Widget (AJAX)
     ======================= */
    var hltCfg = window.highltCore || {};
    var hltI18n = hltCfg.i18n || {};
    var loadingLabel = hltI18n.loading || "Loading…";
    var errorLabel   = hltI18n.error   || "Failed to load. Please try again.";

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
        nonce:  hltCfg.nonce,
        tab:    tab,
      }, settings || {});

      var xhr = $.ajax({
        url:      hltCfg.ajax_url,
        method:   "POST",
        dataType: "json",
        data:     payload,
      })
        .done(function (response) {
          if (response && response.success && response.data && typeof response.data.html === "string") {
            $pane.html(response.data.html);
            $pane.data("hltLoaded", true);
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
      var $area    = $(this);
      var $buttons = $area.find(".tabs-nav .tab-btn");
      var $panes   = $area.find(".content-area .tab-content");

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


    
  });
})(jQuery);
