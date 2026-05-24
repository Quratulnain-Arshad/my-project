const slug = window._cropSlug;
let currentLang = 'en';
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
    render();
  })
  .catch(() => {
    document.getElementById('cropTitle').textContent = 'Failed to load';
  });

function render() {
  const d = cropData;
  const isRtl = currentLang === 'ur';
  const detailKey = currentLang === 'en' ? 'english' : 'urdu';

  document.body.style.direction = isRtl ? 'rtl' : 'ltr';

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

  // ── Image gallery ────────────────────────────────────────────────
  if (hasImages) {
    const grid = document.createElement('div');
    grid.className = 'guide-grid';
    imgSecs.forEach(sec => {
      const card = document.createElement('div');
      card.className = 'guide-card';
      card.innerHTML = `
        <img src="${sec.image}" alt="${sec.label || ''}" class="guide-img" onclick="openImgModal(this.src)">
        <div class="guide-label" style="text-align:${isRtl ? 'right' : 'center'}">${sec.label || ''}</div>`;
      grid.appendChild(card);
    });
    content.appendChild(grid);
  }

  // ── Detail sections ──────────────────────────────────────────────
  if (hasDetails) {
    const detailWrap = document.createElement('div');
    detailWrap.className = 'detail-section';

    if (hasImages) {
      // Hide behind a toggle button when there are also gallery images
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
    // No images and no sections — show placeholder
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
    vidSection.innerHTML = `<h2 class="section-heading"><i class="fa-brands fa-youtube"></i> Videos</h2>`;
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
}

document.getElementById('langToggle').addEventListener('click', () => {
  currentLang = currentLang === 'en' ? 'ur' : 'en';
  render();
});
