let currentLang = "en";
let translations = {};

// Load JSON language file
fetch("farmingCal.json")
    .then(response => response.json())
    .then(data => {
        translations = data;
        applyLanguage(); // Apply English by default
    });

// Switch language button
document.getElementById("langBtn").addEventListener("click", () => {
    currentLang = currentLang === "en" ? "ur" : "en";
    applyLanguage();
});

// Apply language from JSON file
function applyLanguage() {
    const t = translations[currentLang];

    document.getElementById("title").innerText = t.title;
    document.getElementById("label1").innerText = t.label1;
    document.getElementById("label2").innerText = t.label2;
    document.getElementById("label3").innerText = t.label3;
    document.getElementById("label4").innerText = t.label4;
    document.getElementById("label5").innerText = t.label5;
    document.getElementById("totalBtn").innerText = t.totalBtn;
    document.getElementById("langBtn").innerText = t.langBtn;
}

// Calculate total cost
document.getElementById("totalBtn").addEventListener("click", () => {
    let h = Number(document.getElementById("harvest").value);
    let p = Number(document.getElementById("pesticide").value);
    let s = Number(document.getElementById("seed").value);
    let l = Number(document.getElementById("labour").value);
    let f = Number(document.getElementById("fertilizer").value);

    let total = h + p + s + l + f;

    document.getElementById("result").innerText =
        (currentLang === "en" ? "Total Cost: " : "کل خرچ: ") + total;
});

