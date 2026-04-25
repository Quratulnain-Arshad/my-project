let isEnglish = true;
let currentCrop = null;
let data = {};

fetch("json/agri.json")
  .then(res => res.json())
  .then(json => {
    data = json;
  });

function showCrop(crop) {
  currentCrop = crop;
  updateUI();
}

function updateUI() {
  if (!currentCrop) return;

  const crop = data[currentCrop];
  const output = document.getElementById("output");

  if (isEnglish) {
    output.innerHTML = `
      <h2>${crop.name_en}</h2>
      <p>${crop.desc_en}</p>
      <pre>${crop.details_en}</pre>
    `;
  } else {
    output.innerHTML = `
      <h2>${crop.name_ur}</h2>
      <p>${crop.desc_ur}</p>
      <pre>${crop.details_ur}</pre>
    `;
  }
}

document.getElementById("langBtn").onclick = () => {
  isEnglish = !isEnglish;

  document.getElementById("langBtn").innerText =
    isEnglish ? "اردو" : "English";

  updateUI();
};