  let currentLang = "en";
    let data = {};
    fetch("../backend/api/crop-info.php", { cache: "no-store" })
      .then(response => response.json())
      .then(json => {
        if (json.error) { document.getElementById("title").innerText = json.error; return; }
        data = json.languages;
        updateLanguage();
      })
      .catch(err => { document.getElementById("title").innerText = "Failed to load data. Check console."; console.error(err); });

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
        card.href = crop.link;
        card.style.textDecoration = "none";
        card.style.color = "inherit";
        const imgHtml = crop.image
          ? `<img src="${crop.image}" alt="${crop.name}" onerror="this.style.display='none'">`
          : `<div style="height:160px;background:#e8f5e9;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:2.5rem"><i class='fa-solid fa-leaf'></i></div>`;
        card.innerHTML = `${imgHtml}<div class="crop-info"><h3>${crop.name}</h3><p>${crop.desc}</p></div>`;
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