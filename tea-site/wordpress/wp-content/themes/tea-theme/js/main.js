/* TEA Theme v3 — cinematic interactions (hero reel, grain, parallax, reveal, carousel, sticky bar, toast, tabs, hero ken burns) */
(function () {
  'use strict';

  var reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  /* ---------- Grain overlay (SVG fractal noise drift + lerp) ---------- */
  (function grain() {
    var g = document.getElementById('tea-grain');
    if (!g || reduceMotion) return;
    var target = 0, current = 0, ticking = false;
    window.addEventListener('scroll', function () {
      target = window.scrollY;
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(function step() {
          current += (target - current) * 0.06;
          g.style.transform = 'translate3d(' + ((current * 0.08) % 80 - 40) + 'px,' + ((current * -0.05) % 80 - 40) + 'px,0)';
          if (Math.abs(target - current) > 0.5) requestAnimationFrame(step);
          else ticking = false;
        });
      }
    }, { passive: true });
  })();

  /* ---------- Staggered reveal (IntersectionObserver) ---------- */
  (function reveals() {
    var els = document.querySelectorAll('[data-reveal]');
    if (!els.length) return;
    if (reduceMotion || !('IntersectionObserver' in window)) {
      els.forEach(function (el) { el.classList.add('is-visible'); });
      return;
    }
    var io = new IntersectionObserver(function (entries) {
      entries.forEach(function (e) {
        if (!e.isIntersecting) return;
        e.target.classList.add('is-visible');
        io.unobserve(e.target);
      });
    }, { threshold: 0.15, rootMargin: '0px 0px -6% 0px' });
    els.forEach(function (el) { io.observe(el); });
  })();

  /* ---------- Hero reel: Ken Burns frames + progress + chapter + sound bar ---------- */
  (function heroReel() {
    var root = document.getElementById('tea-hero-reel');
    if (!root) return;
    var slides = Array.prototype.slice.call(root.querySelectorAll('.reel-slide'));
    var progressFill = root.querySelector('[data-reel-progress-fill]');
    var chapter = root.querySelector('[data-reel-chapter]');
    var dotsWrap = root.querySelector('[data-reel-dots]');
    var DURATION = 5000;
    var idx = 0, rafStart = null, paused = false, timer = null;

    slides.forEach(function (_, n) {
      if (!dotsWrap) return;
      var d = document.createElement('button');
      d.type = 'button';
      d.setAttribute('aria-label', 'สไลด์ ' + (n + 1));
      d.innerHTML = '<i></i>';
      if (n === 0) d.classList.add('is-active');
      d.addEventListener('click', function () { go(n, true); });
      dotsWrap.appendChild(d);
    });

    function animateProgress() {
      if (progressFill) {
        progressFill.style.transition = 'none';
        progressFill.style.transform = 'scaleX(0)';
        void progressFill.offsetWidth;
        progressFill.style.transition = 'transform ' + DURATION + 'ms linear';
        progressFill.style.transform = 'scaleX(1)';
      }
    }

    function go(n, manual) {
      idx = (n + slides.length) % slides.length;
      slides.forEach(function (s, i) { s.classList.toggle('is-active', i === idx); });
      if (dotsWrap) Array.prototype.forEach.call(dotsWrap.children, function (d, i) { d.classList.toggle('is-active', i === idx); });
      if (chapter) chapter.textContent = String(idx + 1).padStart(2, '0') + ' / ' + String(slides.length).padStart(2, '0');
      animateProgress();
      restart();
    }

    function restart() {
      clearTimeout(timer);
      timer = setTimeout(function () { if (!paused) go(idx + 1); }, DURATION);
    }

    root.addEventListener('click', function (e) {
      var nav = e.target.closest('[data-reel-dir]');
      if (nav) go(idx + parseInt(nav.dataset.reelDir, 10), true);
    });
    root.addEventListener('mouseenter', function () { paused = true; });
    root.addEventListener('mouseleave', function () { paused = false; });
    document.addEventListener('keydown', function (e) {
      if (e.key === 'ArrowRight') go(idx + 1, true);
      if (e.key === 'ArrowLeft') go(idx - 1, true);
    });

    /* sound bar toggle (แสดงสถานะเสียงประกอบ) */
    var soundBtn = root.querySelector('[data-reel-sound]');
    if (soundBtn) soundBtn.addEventListener('click', function () {
      var on = root.classList.toggle('has-sound');
      soundBtn.setAttribute('aria-pressed', on ? 'true' : 'false');
    });

    /* parallax hero image */
    if (!reduceMotion) {
      var img = root.querySelectorAll('.reel-slide img');
      window.addEventListener('scroll', function () {
        var y = window.scrollY;
        if (y > window.innerHeight) return;
        img.forEach(function (im) { im.style.translate = '0 ' + (y * 0.3) + 'px'; });
      }, { passive: true });
    }

    animateProgress();
    restart();
  })();

  /* ---------- Marquee ticker (CSS ทำ animation, JS โคลนเนื้อหาให้วนรอบ) ---------- */
  document.querySelectorAll('.marquee-track').forEach(function (track) {
    track.innerHTML += track.innerHTML;
  });

  /* ---------- Custom carousel: drag + momentum + rubber-band + autoplay ---------- */
  document.querySelectorAll('[data-carousel]').forEach(function (root) {
    var track = root.querySelector('.carousel-track');
    var cards = Array.prototype.slice.call(track.children);
    if (!track || cards.length < 2) return;
    var dotsWrap = root.querySelector('[data-carousel-dots]');
    var AUTOPLAY = 4500;
    var index = 0, offset = 0, startX = 0, startOffset = 0, velocity = 0, lastX = 0, lastT = 0;
    var dragging = false, hovering = false, momentumRaf = null, autoplayTimer = null;

    function cardStep() {
      if (!cards[0]) return 1;
      var style = cards[0].currentStyle || window.getComputedStyle(cards[0]);
      return cards[0].offsetWidth + parseFloat(style.marginRight || 24);
    }

    function maxOffset() { return Math.max(0, (cards.length) * cardStep() - root.querySelector('.carousel-viewport').clientWidth); }

    function render(rubber) {
      var max = maxOffset();
      var x = offset;
      if (rubber && (x < 0 || x > max)) {
        x = x < 0 ? x * 0.35 : max + (x - max) * 0.35;
      } else {
        x = Math.max(0, Math.min(max, x));
      }
      track.style.transform = 'translate3d(' + (-x) + 'px,0,0)';
      var step = cardStep();
      index = Math.max(0, Math.min(cards.length - 1, Math.round(x / step)));
      if (dotsWrap) Array.prototype.forEach.call(dotsWrap.children, function (d, i) { d.classList.toggle('is-active', i === index); });
    }

    function snap() { offset = index * cardStep(); render(); }

    function momentum() {
      offset += velocity;
      velocity *= 0.92;
      render(true);
      if (Math.abs(velocity) > 0.6) momentumRaf = requestAnimationFrame(momentum);
      else snap();
    }

    function down(x) { dragging = true; startX = lastX = x; startOffset = offset; velocity = 0; cancelAnimationFrame(momentumRaf); stopAuto(); }
    function move(x) {
      if (!dragging) return;
      var now = performance.now();
      velocity = (x - lastX) / Math.max(1, now - lastT) * 14;
      lastX = x; lastT = now;
      offset = startOffset - (x - startX);
      render(true);
    }
    function up() {
      if (!dragging) return;
      dragging = false;
      if (Math.abs(velocity) > 1.2) momentum();
      else snap();
      startAuto();
    }

    var viewport = root.querySelector('.carousel-viewport');
    viewport.addEventListener('mousedown', function (e) { e.preventDefault(); down(e.clientX); });
    window.addEventListener('mousemove', function (e) { move(e.clientX); });
    window.addEventListener('mouseup', up);
    viewport.addEventListener('touchstart', function (e) { down(e.touches[0].clientX); }, { passive: true });
    viewport.addEventListener('touchmove', function (e) { move(e.touches[0].clientX); }, { passive: true });
    viewport.addEventListener('touchend', up);

    root.addEventListener('click', function (e) {
      var nav = e.target.closest('[data-carousel-dir]');
      if (!nav) return;
      var dir = parseInt(nav.dataset.carouselDir, 10);
      index = Math.max(0, Math.min(cards.length - 1, index + dir));
      snap();
    });

    root.addEventListener('mouseenter', function () { hovering = true; stopAuto(); });
    root.addEventListener('mouseleave', function () { hovering = false; startAuto(); });

    function stopAuto() { clearInterval(autoplayTimer); }
    function startAuto() {
      if (reduceMotion) return;
      stopAuto();
      autoplayTimer = setInterval(function () {
        if (dragging || hovering) return;
        index = (index + 1) % cards.length;
        snap();
      }, AUTOPLAY);
    }

    if (dotsWrap) cards.forEach(function (_, n) {
      var d = document.createElement('button');
      d.type = 'button';
      d.setAttribute('aria-label', 'การ์ด ' + (n + 1));
      if (n === 0) d.classList.add('is-active');
      d.addEventListener('click', function () { index = n; snap(); });
      dotsWrap.appendChild(d);
    });

    window.addEventListener('resize', snap);
    render();
    startAuto();
  });

  /* ---------- Sticky bottom CTA bar (หลัง hero, ซ่อนใกล้ footer/contact) ---------- */
  (function stickyBar() {
    var bar = document.getElementById('tea-sticky-bar');
    if (!bar) return;
    var hero = document.getElementById('tea-hero-reel');
    var footer = document.querySelector('.site-footer');
    function update() {
      var past = hero ? window.scrollY > hero.offsetHeight * 0.7 : window.scrollY > 400;
      var nearFooter = footer && footer.getBoundingClientRect().top < window.innerHeight + 80;
      bar.classList.toggle('is-visible', past && !nearFooter);
    }
    window.addEventListener('scroll', update, { passive: true });
    update();
  })();

  /* ---------- Toast ---------- */
  window.teaToast = function (message) {
    var t = document.getElementById('tea-toast');
    if (!t) {
      t = document.createElement('div');
      t.id = 'tea-toast';
      t.setAttribute('role', 'status');
      document.body.appendChild(t);
    }
    t.textContent = message;
    t.classList.add('is-visible');
    clearTimeout(t._hide);
    t._hide = setTimeout(function () { t.classList.remove('is-visible'); }, 4200);
  };

  /* ---------- Tabs (audience / news / resources) ---------- */
  function tabs(attrBtn, attrPanel) {
    document.querySelectorAll('[' + attrBtn + ']').forEach(function (btn) {
      btn.addEventListener('click', function () {
        var key = btn.getAttribute(attrBtn);
        document.querySelectorAll('[' + attrBtn + ']').forEach(function (b) { b.classList.toggle('is-active', b === btn); });
        document.querySelectorAll('[' + attrPanel + ']').forEach(function (p) { p.hidden = p.getAttribute(attrPanel) !== key; });
      });
    });
  }
  tabs('data-audience', 'data-audience-panel');
  tabs('data-newstab', 'data-newstab-panel');
  tabs('data-resource', 'data-resource-panel');

  /* ---------- Search panel ---------- */
  var st = document.getElementById('tea-search-toggle');
  var sp = document.getElementById('tea-search-panel');
  if (st && sp) st.addEventListener('click', function () {
    var open = !sp.hidden;
    sp.hidden = open;
    st.setAttribute('aria-expanded', open ? 'false' : 'true');
    if (!open) sp.querySelector('input[type=search]').focus();
  });

  /* ---------- Contact intake form (pill + radio-card + toast) ---------- */
  var form = document.getElementById('tea-contact-form');
  if (form) {
    form.addEventListener('submit', function (e) {
      e.preventDefault();
      var name = form.querySelector('[name=tea_name]').value.trim();
      if (!name) { window.teaToast('กรุณากรอกชื่อของคุณก่อนส่ง'); return; }
      window.teaToast('ส่งข้อความเรียบร้อย — เจ้าหน้าที่สมาคมจะติดต่อกลับโดยเร็ว');
      form.reset();
    });
  }
})();
