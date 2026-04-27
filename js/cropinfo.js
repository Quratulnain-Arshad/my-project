  let currentLang = "en";
    let data = {};
    fetch("json/cropinfo.json")
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
      document.getElementById("langSwitch").innerText = langData.switchLanguage;
      const container = document.getElementById("cropList");
      container.innerHTML = "";

      langData.crops.forEach(crop => {
        const card = document.createElement("a");
        card.className = "crop-card";
        card.href=crop.link;
        card.style.textDecoration="none";
        card.style.color="inherit"
        card.innerHTML = `
          <img src="${crop.image}" alt="${crop.name}">
          <div class="crop-info">
            <h3>${crop.name}</h3>
            <p>${crop.desc}</p>
          </div>
        `;
        container.appendChild(card);
      });
      document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
      document.querySelectorAll(".crop-info").forEach(div => {
        div.style.textAlign = currentLang === "ur" ? "right" : "left";
      });
    }

    document.getElementById("langSwitch").addEventListener("click", () => {
      currentLang = currentLang === "en" ? "ur" : "en";
      updateLanguage();
    });
    langData.crops.forEach(crop => {
  const card = document.createElement("a");
  card.className = "crop-card";
  card.href = crop.link;
  card.style.textDecoration = "none";
  card.style.color = "inherit";

  card.innerHTML = `
    <img src="${crop.image}" alt="${crop.name}">
    <div class="crop-info">
      <h3>${crop.name}</h3>
      <p>${crop.desc}</p>
    </div>
  `;

  container.appendChild(card);
});