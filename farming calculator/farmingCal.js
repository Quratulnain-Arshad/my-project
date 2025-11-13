let currentLang = "en";
let translations = {};

fetch("farmingCal.json")
  .then(response => response.json())
  .then(data => {
    translations = data;
    applyTranslations();
  });

document.getElementById("langToggle").addEventListener("click", () => {
  currentLang = currentLang === "en" ? "ur" : "en";
  applyTranslations();
});

function applyTranslations() {
  const t = translations[currentLang];
  if (!t) return;
  document.getElementById("title").textContent = t.title;
  document.getElementById("cropLabel").textContent = t.cropLabel;
  document.getElementById("landLabel").textContent = t.landLabel;
  document.getElementById("seedLabel").textContent = t.seedLabel;
  document.getElementById("fertilizerLabel").textContent = t.fertilizerLabel;
  document.getElementById("pesticideLabel").textContent = t.pesticideLabel;
  document.getElementById("yieldLabel").textContent = t.yieldLabel;
  document.getElementById("calculate").textContent = t.calculate;
  const langButton = document.getElementById("langToggle");
  if (currentLang === "en") {
    langButton.textContent = "اردو";}
    else{
      langButton.textContent="English";
    }
    document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
  }

  // Calculate button
  document.getElementById("calculate").addEventListener("click", () => {
    const land = parseFloat(document.getElementById("land").value) || 0;
    const seed = parseFloat(document.getElementById("seed").value) || 0;
    const fert = parseFloat(document.getElementById("fertilizer").value) || 0;
    const pest = parseFloat(document.getElementById("pesticide").value) || 0;
    const yieldPerAcre = parseFloat(document.getElementById("yield").value) || 0;

    const totalCost = land * (seed + fert + pest);
    const totalYield = land * yieldPerAcre;

    const result = document.getElementById("result");
    result.style.display = "block";
    result.innerHTML = `
    <strong>Total Cost:</strong> Rs ${totalCost.toLocaleString()}<br>
    <strong>Total Expected Yield:</strong> ${totalYield.toLocaleString()} kg
  `;
  });