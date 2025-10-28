    let langData;
    let currentLang = "en";

    // Load JSON language file
    fetch("lang.json")
      .then((res) => res.json())
      .then((data) => {
        langData = data.languages;
        updateLanguage(currentLang);
      });

    // Switch language button
    document.getElementById("switchLang").addEventListener("click", () => {
      currentLang = currentLang === "en" ? "ur" : "en";
      updateLanguage(currentLang);
    });

    // Update text according to selected language
    function updateLanguage(lang) {
      const t = langData[lang];
      document.getElementById("title").textContent = t.title;
      document.getElementById("labelCrop").textContent = t.selectCrop;
      document.getElementById("chooseCrop").textContent = t.chooseCrop;
      document.getElementById("labelLand").textContent = t.landArea;
      document.getElementById("labelSeed").textContent = t.seedCost;
      document.getElementById("labelFertilizer").textContent = t.fertilizerCost;
      document.getElementById("labelPesticide").textContent = t.pesticideCost;
      document.getElementById("labelYield").textContent = t.yield;
      document.getElementById("calculateBtn").textContent = t.calculate;
      document.getElementById("footer").textContent = t.footer;
      document.getElementById("switchLang").textContent = t.switchLang;

      // RTL layout for Urdu
      document.getElementById("calcBox").style.direction = lang === "ur" ? "rtl" : "ltr";
    }

    // Calculate estimation
    document.getElementById("calculateBtn").addEventListener("click", () => {
      const t = langData[currentLang];
      const area = +document.getElementById("area").value;
      const seed = +document.getElementById("seedCost").value;
      const fert = +document.getElementById("fertilizerCost").value;
      const pest = +document.getElementById("pesticideCost").value;

      if (!area) {
        document.getElementById("result").textContent = t.errorText;
        return;
      }

      const total = area * (seed + fert + pest);
      document.getElementById("result").textContent = ${t.resultText} ${total.toLocaleString()};
    });