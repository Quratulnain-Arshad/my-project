const slug = window._cropSlug;
let currentLang = getLang(); // restored from localStorage
let cropData = null;

fetch('../backend/api/crop.php?slug=' + encodeURIComponent(slug), { cache: 'no-store' })
  .then(r => r.json())
  .then(data => {
    if (data.error) {
      document.getElementById('cropTitle').textContent = 'Crop not found';
      document.getElementById('cropContent').innerHTML =
        '<p style="text-align:center;padding:60px 20px;color:#aaa;font-size:.95rem">This crop does not exist or has been removed.</p>';
      return;
    }
    cropData = data;
    ensureSectionModal();
    render();
  })
  .catch(() => {
    document.getElementById('cropTitle').textContent = 'Failed to load';
  });

function ensureSectionModal() {
  if (document.getElementById('sectionModal')) return;
  const modal = document.createElement('div');
  modal.id = 'sectionModal';
  modal.className = 'section-modal';
  modal.innerHTML = `
    <div class="section-modal-box" onclick="event.stopPropagation()">
      <button type="button" class="section-modal-close" id="sectionModalClose">&times;</button>
      <img id="sectionModalImg" class="section-modal-img" alt="">
      <h2 id="sectionModalTitle" class="section-modal-title"></h2>
      <div id="sectionModalBody" class="section-modal-body"></div>
    </div>`;
  modal.addEventListener('click', closeSectionModal);
  document.body.appendChild(modal);
  document.getElementById('sectionModalClose').addEventListener('click', closeSectionModal);
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeSectionModal();
  });
}

function openSectionModal(sec, isRtl) {
  const modal = document.getElementById('sectionModal');
  const img = document.getElementById('sectionModalImg');
  const title = document.getElementById('sectionModalTitle');
  const body = document.getElementById('sectionModalBody');

  if (sec.image) {
    img.src = sec.image;
    img.style.display = 'block';
  } else {
    img.removeAttribute('src');
    img.style.display = 'none';
  }

  title.textContent = sec.label || '';
  title.style.textAlign = isRtl ? 'right' : 'left';
  body.style.textAlign = isRtl ? 'right' : 'left';
  body.setAttribute('dir', isRtl ? 'rtl' : 'ltr');

  const text = (sec.content || '').trim();
  if (text) {
    body.innerHTML = text.replace(/\n/g, '<br>');
  } else {
    body.innerHTML = `<p class="section-modal-empty">${isRtl ? 'اس عنوان کی تفصیل ابھی دستیاب نہیں۔ مکمل تفصیل نیچے دیکھیں۔' : 'No short detail for this topic yet. See full details below.'}</p>`;
  }

  modal.classList.add('open');
  document.body.style.overflow = 'hidden';
}

function closeSectionModal() {
  const modal = document.getElementById('sectionModal');
  if (modal) modal.classList.remove('open');
  document.body.style.overflow = '';
}

function render() {
  const d = cropData;
  const isRtl = currentLang === 'ur';
  const detailKey = currentLang === 'en' ? 'english' : 'urdu';

  document.body.style.direction = isRtl ? 'rtl' : 'ltr';
  document.body.setAttribute('dir', isRtl ? 'rtl' : 'ltr');

  const guide   = d.guide[currentLang] || {};
  const details = d.details[detailKey] || {};
  const imgSecs = (guide.sections || []).filter(s => s.image && s.image.trim());

  document.getElementById('cropTitle').textContent = d.name[currentLang] || slug;
  document.getElementById('langToggle').textContent = isRtl ? 'English' : 'اردو';

  const content = document.getElementById('cropContent');
  content.innerHTML = '';
  content.setAttribute('dir', isRtl ? 'rtl' : 'ltr');

  const hasImages  = imgSecs.length > 0;
  const hasDetails = !!(details.sections && details.sections.length > 0);

  // ── Image gallery (tap opens related detail dialog) ──────────────
  if (hasImages) {
    const grid = document.createElement('div');
    grid.className = 'guide-grid';
    imgSecs.forEach(sec => {
      const card = document.createElement('div');
      card.className = 'guide-card';
      card.setAttribute('role', 'button');
      card.tabIndex = 0;
      card.innerHTML = `
        <img src="${sec.image}" alt="${sec.label || ''}" class="guide-img">
        <div class="guide-label" style="text-align:${isRtl ? 'right' : 'center'}">${sec.label || ''}</div>
        <div class="guide-hint">${isRtl ? 'تفصیل دیکھیں' : 'Tap for details'}</div>`;
      const open = () => openSectionModal(sec, isRtl);
      card.addEventListener('click', open);
      card.addEventListener('keydown', (e) => {
        if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); open(); }
      });
      grid.appendChild(card);
    });
    content.appendChild(grid);
  }

  // ── Full detail sections (unchanged) ─────────────────────────────
  if (hasDetails) {
    const detailWrap = document.createElement('div');
    detailWrap.className = 'detail-section';

    if (hasImages) {
      detailWrap.style.display = 'none';
      const btnRow = document.createElement('div');
      btnRow.className = 'btn-row';
      const btn = document.createElement('button');
      btn.className = 'next-btn';
      btn.textContent = isRtl ? 'تفصیل دیکھیں' : 'View Details';
      let open = false;
      btn.addEventListener('click', () => {
        open = !open;
        detailWrap.style.display = open ? 'block' : 'none';
        btn.textContent = open
          ? (isRtl ? 'چھپائیں' : 'Hide Details')
          : (isRtl ? 'تفصیل دیکھیں' : 'View Details');
        if (open) detailWrap.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
      btnRow.appendChild(btn);
      content.appendChild(btnRow);
    }

    details.sections.forEach(sec => {
      const card = document.createElement('div');
      card.className = 'detail-card';
      const body = (sec.content || '').replace(/\n/g, '<br>');
      card.innerHTML = `
        <h3 style="text-align:${isRtl ? 'right' : 'left'}">${sec.heading || ''}</h3>
        <div class="detail-content" style="text-align:${isRtl ? 'right' : 'left'}">${body}</div>`;
      detailWrap.appendChild(card);
    });

    content.appendChild(detailWrap);

  } else if (!hasImages) {
    content.innerHTML = `
      <div style="text-align:center;padding:60px 20px;color:#bbb">
        <div style="font-size:3rem;margin-bottom:12px">🌱</div>
        <p style="font-size:.95rem">${isRtl ? 'ابھی کوئی مواد شامل نہیں کیا گیا۔' : 'No content added yet for this crop.'}</p>
      </div>`;
  }

  // ── YouTube videos ───────────────────────────────────────────────
  if (d.videos && d.videos.length > 0) {
    const vidSection = document.createElement('div');
    vidSection.className = 'video-section';
    const vidTitle = isRtl ? 'ویڈیوز' : 'Videos';
    vidSection.innerHTML = `<h2 class="section-heading"><i class="fa-brands fa-youtube"></i> ${vidTitle}</h2>`;
    const vidGrid = document.createElement('div');
    vidGrid.className = 'video-grid';
    d.videos.forEach(vid => {
      const wrap = document.createElement('div');
      wrap.className = 'video-wrap';
      wrap.innerHTML = `<iframe src="https://www.youtube.com/embed/${encodeURIComponent(vid)}" allowfullscreen loading="lazy"></iframe>`;
      vidGrid.appendChild(wrap);
    });
    vidSection.appendChild(vidGrid);
    content.appendChild(vidSection);
  }

  updateNavFooter(isRtl);
}

document.getElementById('langToggle').addEventListener('click', () => {
  currentLang = currentLang === 'en' ? 'ur' : 'en';
  setLang(currentLang);
  render();
});
