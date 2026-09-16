/* TEA Announcements v2 — พฤติกรรมตามต้นฉบับ */
(function () {
  var items = window.TEA_ANNOUNCEMENTS || [];
  var backdrop = document.getElementById('tea-popup-backdrop');
  var modal = document.getElementById('tea-announcement-modal');
  if (!items.length || !backdrop || !modal) return;

  var slides = modal.querySelectorAll('.tea-modal-slide');
  var dotsWrap = modal.querySelector('[data-tea-dots]');
  var elCount = modal.querySelector('[data-tea-count]');
  var elKicker = modal.querySelector('[data-tea-kicker]');
  var elTitle = modal.querySelector('[data-tea-title]');
  var elDesc = modal.querySelector('[data-tea-desc]');
  var elBtn = modal.querySelector('[data-tea-btn]');
  var elSource = modal.querySelector('[data-tea-source]');
  var imagePanel = modal.querySelector('.modal-image');
  var idx = 0, timer;

  // A remembered dismissal belongs to this exact popup set.  When editors
  // publish a new priority announcement, it must still be surfaced once.
  var DISMISS_KEY = 'tea-announcements-v5-dismissed-' + items.map(function (item) {
    return item.id;
  }).join('-');

  function pad(n) { return String(n).padStart(2, '0'); }

  function buildDots() {
    if (!dotsWrap) return;
    items.forEach(function (_, n) {
      var b = document.createElement('button');
      b.type = 'button';
      b.setAttribute('role', 'tab');
      b.setAttribute('aria-label', 'ประกาศ ' + (n + 1));
      if (n === 0) b.classList.add('is-active');
      b.addEventListener('click', function () { go(n); });
      dotsWrap.appendChild(b);
    });
  }

  function go(n) {
    idx = (n + items.length) % items.length;
    var it = items[idx];
    slides.forEach(function (s, i) { s.hidden = i !== idx; });
    if (dotsWrap) Array.prototype.forEach.call(dotsWrap.children, function (b, i) { b.classList.toggle('is-active', i === idx); });
    if (elCount) elCount.textContent = pad(idx + 1) + ' / ' + pad(items.length);
    if (elKicker) elKicker.textContent = it.kicker;
    if (elTitle) elTitle.textContent = it.title;
    if (elDesc) elDesc.textContent = it.excerpt;
    if (elBtn) { elBtn.textContent = it.btnText; elBtn.href = it.link; }
    if (elSource) elSource.textContent = (window.tea_ann_is_en ? 'Source: ' : 'ที่มา: ') + (it.source || document.title);
    if (imagePanel) {
      var currentImage = slides[idx].querySelector('img');
      imagePanel.style.setProperty('--tea-slide-background', currentImage ? 'url("' + currentImage.src + '")' : 'none');
    }
    modal.classList.toggle('memorial-modal', !!it.memorial);
    restart();
  }

  function restart() {
    clearInterval(timer);
    timer = setTimeout(function () { go(idx + 1); }, idx === 0 ? 12000 : 6500);
  }

  function dismissed() {
    try { return localStorage.getItem(DISMISS_KEY); } catch (e) { return false; }
  }

  function close(remember) {
    clearTimeout(timer);
    try {
      if (remember) localStorage.setItem(DISMISS_KEY, 'true');
      else if (items[idx].freq === 'daily') localStorage.setItem(DISMISS_KEY + '-' + items[idx].id, new Date().toDateString());
    } catch (e) {}
    backdrop.hidden = true;
  }

  function open() {
    backdrop.hidden = false;
    go(0);
  }

  modal.addEventListener('click', function (e) {
    var t = e.target;
    if (t.closest('[data-tea-close]')) { close(t.closest('.remember-close') !== null); return; }
    var nav = t.closest('[data-tea-dir]');
    if (nav) { go(idx + parseInt(nav.dataset.teaDir, 10)); }
  });

  backdrop.addEventListener('mousedown', function (e) {
    if (e.target === backdrop) close(false);
  });

  document.addEventListener('keydown', function (e) {
    if (backdrop.hidden) return;
    if (e.key === 'Escape') close(false);
    if (e.key === 'ArrowRight') go(idx + 1);
    if (e.key === 'ArrowLeft') go(idx - 1);
  });

  window.teaOpenAnnouncements = open;

  buildDots();
  if (!dismissed()) setTimeout(open, 900);
})();
