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
        Vertical Slider area (GSAP)
     ======================= */
    var $vertSlider = $(".vertical-slider");

    if ($vertSlider.length) {
      var vsSettings = JSON.parse($vertSlider.attr("data-settings"));
      var vsDuration = (parseInt(vsSettings.speed) || 1200) / 1000;
      var vsLoop = vsSettings.loop === true;
      var vsAutoplay = vsSettings.autoplay === true;
      var vsDelay = Math.max(parseInt(vsSettings.speed) || 4000, 1000);

      var vsEl = $vertSlider[0];
      var vsAreaEl =
        vsEl.closest(".vertical-slider-area") || vsEl.parentElement;
      var vsSlides = Array.from(vsEl.querySelectorAll(".vs-track .vs-slide"));
      var vsTotal = vsSlides.length;
      var vsCurrent = 0;
      var vsBusy = false;

      if (vsTotal >= 2) {
        // ── Scroll-lock helpers ──────────────────────────────────────────────
        var vsLocked = false;
        var vsCooldown = false;
        var vsScrollbarW =
          window.innerWidth - document.documentElement.clientWidth;

        function vsLock() {
          if (vsLocked || vsCooldown) return;
          vsLocked = true;
          document.documentElement.style.overflow = "hidden";
          if (vsScrollbarW > 0) {
            document.documentElement.style.paddingRight = vsScrollbarW + "px";
          }
        }

        function vsUnlock() {
          if (!vsLocked) return;
          vsLocked = false;
          document.documentElement.style.overflow = "";
          document.documentElement.style.paddingRight = "";
          // 2 s cooldown so the page scrolls fully clear before re-activation is allowed
          vsCooldown = true;
          setTimeout(function () {
            vsCooldown = false;
          }, 2000);
        }

        // ── Scroll-activation detector ───────────────────────────────────────
        var vsPrevScrollY = window.pageYOffset;
        var vsPrevRectTop = null; // tracks last known rect.top for crossing detection

        window.addEventListener(
          "scroll",
          function () {
            var curY = window.pageYOffset;
            var goingDown = curY >= vsPrevScrollY;
            vsPrevScrollY = curY;

            if (vsLocked || vsCooldown) return;

            var rect = vsAreaEl.getBoundingClientRect();
            var rectTop = Math.round(rect.top);

            // Primary zone: slider top is within 400 px above the viewport top.
            // Wide range handles frames where fast scroll jumps many pixels at once.
            var inZone = rectTop <= 0 && rectTop > -400 && rect.bottom > 80;

            // Zero-crossing guard: catches a fast upward scroll where rect.top
            // jumped from negative (slider above viewport) past 0 to a small positive
            // (slider just dipped below viewport top). Only trigger within 150 px overshoot.
            var crossedUp =
              !goingDown &&
              rectTop > 0 &&
              rectTop < 150 &&
              vsPrevRectTop !== null &&
              vsPrevRectTop < 0 &&
              rect.bottom > 80;

            vsPrevRectTop = rectTop;

            if (!inZone && !crossedUp) return;

            // Snap so slider top sits exactly at the viewport top before locking.
            if (rectTop !== 0) {
              window.scrollBy(0, rectTop);
            }

            // Reset slide index to match approach direction.
            if (goingDown && vsCurrent !== 0) {
              vsCurrent = 0;
              vsResetPositions(0);
              vsSync(0);
            } else if (!goingDown && vsCurrent !== vsTotal - 1) {
              vsCurrent = vsTotal - 1;
              vsResetPositions(vsTotal - 1);
              vsSync(vsTotal - 1);
            }

            vsLock();
          },
          { passive: true },
        );

        // ── Pagination ──────────────────────────────────────────────────────
        var vsPagEl = vsEl.querySelector(".vertical-pagination");
        if (vsPagEl) {
          vsSlides.forEach(function (_, i) {
            var b = document.createElement("span");
            b.className =
              "swiper-pagination-bullet" +
              (i === 0 ? " swiper-pagination-bullet-active" : "");
            b.innerHTML =
              '<span class="vertical-slider-btn-wrap"><span></span><span></span><span></span><span></span></span>';
            b.addEventListener("click", function () {
              vsNavigate(i > vsCurrent ? "forward" : "backward", i);
            });
            vsPagEl.appendChild(b);
          });
        }

        function vsSync(idx) {
          if (!vsPagEl) return;
          vsPagEl
            .querySelectorAll(".swiper-pagination-bullet")
            .forEach(function (b, i) {
              b.classList.toggle("swiper-pagination-bullet-active", i === idx);
            });
        }

        function vsResetPositions(idx) {
          vsSlides.forEach(function (s, i) {
            gsap.set(s, {
              zIndex: i + 1,
              yPercent: i <= idx ? 0 : 100,
              scale: 1,
            });
          });
        }

        // Initial stack: slide 0 visible, rest waiting below
        vsSlides.forEach(function (s, i) {
          gsap.set(s, { yPercent: i === 0 ? 0 : 100, scale: 1, zIndex: i + 1 });
        });

        // ── Navigation ──────────────────────────────────────────────────────
        function vsNavigate(direction, targetIndex) {
          var next =
            targetIndex !== undefined
              ? targetIndex
              : direction === "forward"
                ? vsCurrent + 1
                : vsCurrent - 1;

          if (next >= vsTotal) next = vsLoop ? 0 : vsTotal - 1;
          if (next < 0) next = vsLoop ? vsTotal - 1 : 0;
          if (next === vsCurrent || vsBusy) return;

          vsBusy = true;
          var fromSlide = vsSlides[vsCurrent];
          var toSlide = vsSlides[next];

          function onDone() {
            vsCurrent = next;
            vsResetPositions(vsCurrent);
            vsBusy = false;
            vsGestureActive = false;
            vsLastAnimEnd = Date.now();
            vsSync(vsCurrent);
          }

          if (direction === "forward") {
            // Incoming slide rises from below, zooming out as it settles (parallax depth)
            gsap.fromTo(
              toSlide,
              { yPercent: 100, scale: 1.07, zIndex: vsTotal + 1 },
              {
                yPercent: 0,
                scale: 1,
                duration: vsDuration,
                ease: "expo.inOut",
                onComplete: onDone,
              },
            );
            // Outgoing slide drifts backward (upward parallax — like a deeper layer receding)
            gsap.to(fromSlide, {
              yPercent: -8,
              duration: vsDuration,
              ease: "expo.inOut",
            });
          } else {
            // Outgoing slide exits downward
            gsap.set(fromSlide, { zIndex: vsTotal + 1 });
            gsap.set(toSlide, { yPercent: 0, zIndex: vsTotal });
            gsap.to(fromSlide, {
              yPercent: 100,
              duration: vsDuration,
              ease: "expo.inOut",
              onComplete: onDone,
            });
            // Revealed slide zooms out from slight oversize — mirrors the forward parallax
            gsap.fromTo(
              toSlide,
              { scale: 1.07 },
              { scale: 1, duration: vsDuration, ease: "expo.inOut" },
            );
          }
        }

        // ── Wheel handler ────────────────────────────────────────────────────
        var vsGestureActive = false;
        var vsGestureTimer;
        var vsLastAnimEnd = 0;

        document.addEventListener(
          "wheel",
          function (e) {
            if (!vsLocked) return;

            var goForward = e.deltaY > 0;

            // At the boundary with no loop → release lock and let page scroll
            if (goForward && vsCurrent === vsTotal - 1 && !vsLoop) {
              vsUnlock();
              return;
            }
            if (!goForward && vsCurrent === 0 && !vsLoop) {
              vsUnlock();
              return;
            }

            e.preventDefault();

            var now = Date.now();
            // Allow navigation only when:
            //   • not mid-animation (vsBusy)
            //   • not within the same gesture (vsGestureActive)
            //   • at least 200 ms have passed since the last animation ended
            if (!vsGestureActive && !vsBusy && now - vsLastAnimEnd >= 300) {
              vsGestureActive = true;
              vsNavigate(goForward ? "forward" : "backward");
            }

            // Reset gesture gate 700 ms after events stop (end of trackpad momentum)
            clearTimeout(vsGestureTimer);
            vsGestureTimer = setTimeout(function () {
              vsGestureActive = false;
            }, 700);
          },
          { passive: false },
        );

        // ── Autoplay ─────────────────────────────────────────────────────────
        if (vsAutoplay) {
          var vsTimer;
          var vsStartAuto = function () {
            vsTimer = setInterval(function () {
              vsNavigate("forward");
            }, vsDelay);
          };
          vsStartAuto();
          vsEl.addEventListener("mouseenter", function () {
            clearInterval(vsTimer);
          });
          vsEl.addEventListener("mouseleave", vsStartAuto);
        }

        vsSync(0);
      }
    }

    


    
  });
})(jQuery);
