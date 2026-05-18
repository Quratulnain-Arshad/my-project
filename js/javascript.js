let currentLang = "en";
let data = {};
fetch("json/farmdata.json")
  .then(response => response.json())
  .then(json => {
    data = json.languages;
    updateLanguage();
  })
  .catch(err => console.error("Error loading JSON:", err));

function updateLanguage() {
  const langData = data[currentLang];

  document.getElementById("title").innerText = langData.title;
  document.getElementById("subtitle").innerText = langData.subtitle;

  document.getElementById("cropInfo").innerHTML = '<i class="fa-solid fa-seedling"></i><span>' + langData.buttons.cropInfo + '</span>';
  document.getElementById("calculator").innerHTML = '<i class="fa-solid fa-calculator"></i><span>' + langData.buttons.calculator + '</span>';
  document.getElementById("helpline").innerHTML = '<i class="fa-solid fa-headset"></i><span>' + langData.buttons.helpline + '</span>';

  document.getElementById("langSwitch").innerText = langData.switchLanguage;

  document.getElementById("about-heading").innerText = langData.about.heading;
  document.getElementById("about-p1").innerText = langData.about.p1;
  document.getElementById("about-p2").innerText = langData.about.p2;
  document.getElementById("about-p3").innerText = langData.about.p3;

  document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
}

document.getElementById("langSwitch").addEventListener("click", () => {
  currentLang = currentLang === "en" ? "ur" : "en";
  updateLanguage();
});