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
      document.getElementById("cropInfo").innerHTML = '<img src="https://thumbs.dreamstime.com/b/clip-art-corn-stalks-image-shows-group-tall-green-corn-stalks-yellow-kernels-lush-leaves-emphasizing-their-368151148.jpg"width="50" height="50">'+ langData.buttons.cropInfo;
      document.getElementById("calculator").innerHTML =  '<img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTh6W0FZ7j22ge80m7zUrjbBbakVP1N3J6UOg&s width="50" height="50">'+ langData.buttons.calculator;
      document.getElementById("video").innerHTML = '<img src="">' + langData.buttons.video;
      document.getElementById("langSwitch").innerText = langData.switchLanguage;

      // Change text direction for Urdu
      document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
    }

    document.getElementById("langSwitch").addEventListener("click", () => {
      currentLang = currentLang === "en" ? "ur" : "en";
      updateLanguage();
    });