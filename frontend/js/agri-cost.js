function stripHtml(html) {
  const tmp = document.createElement('div');
  tmp.innerHTML = html;
  return tmp.textContent || tmp.innerText || '';
}

let isEnglish = true;
let currentCrop = null;
let data = {};

fetch("../backend/api/agri-cost.php", { cache: 'no-store' })
  .then(res => res.json())
  .then(json => {
    data = json;
    buildSidebar();
    // Auto-select first crop
    const keys = Object.keys(data);
    if (keys.length > 0) showCrop(keys[0]);
  });

function buildSidebar() {
  const container = document.getElementById('crop-buttons');
  container.innerHTML = '';

  const keys = Object.keys(data);
  if (keys.length === 0) {
    container.innerHTML = '<p style="color:#c8e6c9;font-size:.85rem;padding:10px;text-align:center">No crops added yet</p>';
    return;
  }

  keys.forEach(key => {
    const crop = data[key];
    const btn = document.createElement('button');
    btn.dataset.key = key;
    btn.textContent = stripHtml(isEnglish ? (crop.name_en || key) : (crop.name_ur || key));
    if (key === currentCrop) btn.classList.add('active');
    btn.onclick = () => showCrop(key);
    container.appendChild(btn);
  });

  document.getElementById('sidebarHeading').textContent = isEnglish ? 'Crops' : 'فصلیں';
}

function showCrop(key) {
  currentCrop = key;
  document.querySelectorAll('#crop-buttons button').forEach(b => b.classList.remove('active'));
  const activeBtn = document.querySelector(`#crop-buttons button[data-key="${key}"]`);
  if (activeBtn) activeBtn.classList.add('active');
  updateUI();
}

function updateUI() {
  if (!currentCrop || !data[currentCrop]) return;
  const crop = data[currentCrop];
  const output = document.getElementById('output');

  if (isEnglish) {
    output.setAttribute('dir', 'ltr');
    output.innerHTML = `
      <h2>${crop.name_en || ''}</h2>
      <p>${crop.desc_en || ''}</p>
      <pre class="cost-pre">${crop.details_en || ''}</pre>
    `;
  } else {
    output.setAttribute('dir', 'rtl');
    output.innerHTML = `
      <h2>${crop.name_ur || ''}</h2>
      <p>${crop.desc_ur || ''}</p>
      <pre class="cost-pre">${crop.details_ur || ''}</pre>
    `;
  }
}

document.getElementById('langBtn').onclick = () => {
  isEnglish = !isEnglish;
  document.getElementById('langBtn').innerText = isEnglish ? 'اردو' : 'English';
  buildSidebar();
  updateUI();
};
