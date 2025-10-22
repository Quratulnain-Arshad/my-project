  let currentLang = "en";
    let data = {};

    // Load JSON file
    fetch("cropData.json")
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

      // Clear and rebuild crop list
      const container = document.getElementById("cropList");
      container.innerHTML = "";

      langData.crops.forEach(crop => {
        const card = document.createElement("div");
        card.className = "crop-card";
        card.innerHTML = `
          <img src="${crop.image}" alt="${crop.name}">
          <div class="crop-info">
            <h3>${crop.name}</h3>
            <p>${crop.desc}</p>
          </div>
        `;
        container.appendChild(card);
      });

      // Urdu layout adjustment
      document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
      document.querySelectorAll(".crop-info").forEach(div => {
        div.style.textAlign = currentLang === "ur" ? "right" : "left";
      });
    }

    document.getElementById("langSwitch").addEventListener("click", () => {
      currentLang = currentLang === "en" ? "ur" : "en";
      updateLanguage();
    });