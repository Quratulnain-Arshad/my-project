let currentLang = "en";

async function loadText() {
    const res = await fetch("potato.json");
    const data = await res.json();

    const t = data[currentLang];

    document.getElementById("title").innerText = t.title;

    document.getElementById("intro").innerText = t.intro;
    document.getElementById("climate").innerText = t.climate;
    document.getElementById("soil").innerText = t.soil;

    document.getElementById("sowing").innerText = t.sowing;
    document.getElementById("fertilizer").innerText = t.fertilizer;
    document.getElementById("pests").innerText = t.pests;

    document.getElementById("harvest").innerText = t.harvest;

    // Images update
    document.getElementById("img_intro").src = t.images.intro;
    document.getElementById("img_climate").src = t.images.climate;
    document.getElementById("img_soil").src = t.images.soil;

    document.getElementById("img_sowing").src = t.images.sowing;
    document.getElementById("img_fertilizer").src = t.images.fertilizer;
    document.getElementById("img_pests").src = t.images.pests;

    document.getElementById("img_harvest").src = t.images.harvest;

    document.getElementById("nextBtn").innerText = t.next;
    document.getElementById("langToggle").innerText = t.langBtn;

    document.body.style.direction = currentLang === "ur" ? "rtl" : "ltr";
}

document.getElementById("langToggle").addEventListener("click", () => {
    currentLang = (currentLang === "en") ? "ur" : "en";
    loadText();
});

loadText();