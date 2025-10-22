 let currentLang = "en";
    let data = {};

    // Load JSON file
    fetch("farmdata.json")
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
      document.getElementById("cropInfo").innerText = "🌱 " + langData.buttons.cropInfo;
      document.getElementById("calculator").innerText = "🧮 " + langData.buttons.calculator;
      document.getElementById("video").innerText = "▶️ " + langData.buttons.video;
      document.getElementById("langSwitch").innerText = langData.switchLanguage;

      // Change text direction for Urdu
      document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
    }

    document.getElementById("langSwitch").addEventListener("click", () => {
      currentLang = currentLang === "en" ? "ur" : "en";
      updateLanguage();
    });