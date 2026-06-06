let currentLang = getLang(); // restored from localStorage
let data = {};

fetch("../backend/api/farm-data.php", { cache: 'no-store' })
  .then(response => response.json())
  .then(json => {
    data = json.languages;
    updateLanguage();
  })
  .catch(err => console.error("Error loading JSON:", err));

function updateLanguage() {
  const langData = data[currentLang];
  if (!langData) return;

  // --- Hero Section ---
  document.getElementById("title").innerText = langData.title;
  document.getElementById("subtitle").innerText = langData.subtitle;

  document.getElementById("cropInfo").innerHTML = '<i class="fa-solid fa-seedling"></i><span>' + langData.buttons.cropInfo + '</span>';
  document.getElementById("calculator").innerHTML = '<i class="fa-solid fa-calculator"></i><span>' + langData.buttons.calculator + '</span>';
  document.getElementById("helpline").innerHTML = '<i class="fa-solid fa-headset"></i><span>' + langData.buttons.helpline + '</span>';

  document.getElementById("langSwitch").innerText = langData.switchLanguage;

  // --- About Us Section ---
  document.getElementById("about-heading").innerText = langData.about.heading;
  document.getElementById("about-p1").innerText = langData.about.p1;
  document.getElementById("about-p2").innerText = langData.about.p2;
  document.getElementById("about-p3").innerText = langData.about.p3;

  // --- How It Works Section ---
  const hiw = langData.howItWorks;
  if (hiw) {
    document.getElementById("hiw-heading").innerText = hiw.heading;
    document.getElementById("hiw-subtitle").innerText = hiw.subtitle;
    document.getElementById("hiw-step1-title").innerText = hiw.step1.title;
    document.getElementById("hiw-step1-desc").innerText = hiw.step1.desc;
    document.getElementById("hiw-step2-title").innerText = hiw.step2.title;
    document.getElementById("hiw-step2-desc").innerText = hiw.step2.desc;
    document.getElementById("hiw-step3-title").innerText = hiw.step3.title;
    document.getElementById("hiw-step3-desc").innerText = hiw.step3.desc;
  }

  // --- Features Section ---
  const feat = langData.features;
  if (feat) {
    document.getElementById("feat-heading").innerText = feat.heading;
    document.getElementById("feat-subtitle").innerText = feat.subtitle;
    document.getElementById("feat1-title").innerText = feat.feat1.title;
    document.getElementById("feat1-desc").innerText = feat.feat1.desc;
    document.getElementById("feat2-title").innerText = feat.feat2.title;
    document.getElementById("feat2-desc").innerText = feat.feat2.desc;
    document.getElementById("feat3-title").innerText = feat.feat3.title;
    document.getElementById("feat3-desc").innerText = feat.feat3.desc;
    document.getElementById("feat4-title").innerText = feat.feat4.title;
    document.getElementById("feat4-desc").innerText = feat.feat4.desc;
  }

  // --- RTL / LTR direction ---
  document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
  updateNavFooter(currentLang === "ur");
}

document.getElementById("langSwitch").addEventListener("click", () => {
  currentLang = currentLang === "en" ? "ur" : "en";
  setLang(currentLang); // persist choice
  updateLanguage();
});