// Read saved language; these pages use "english"/"urdu" keys
let currentLang = getLang() === 'ur' ? 'urdu' : 'english';
let data = {};

document.addEventListener("DOMContentLoaded", () => {
    loadJSON();
    document.getElementById("langBtn").addEventListener("click", toggleLanguage);
    // Set correct button label on load
    document.getElementById("langBtn").innerText = currentLang === 'english' ? 'اردو' : 'English';
});

function loadJSON() {
    fetch("../backend/api/wheat-info.php", { cache: 'no-store' })
        .then(res => res.json())
        .then(json => {
            data = json;
            renderPage();
        });
}

function toggleLanguage() {
    currentLang = currentLang === 'english' ? 'urdu' : 'english';
    setLang(currentLang === 'urdu' ? 'ur' : 'en'); // persist
    document.getElementById("langBtn").innerText = currentLang === 'english' ? 'اردو' : 'English';
    renderPage();
}

function renderPage() {
    const langData = data[currentLang];
    if (!langData) return;

    document.getElementById("title").innerText = langData.title;

    const contentDiv = document.getElementById("content");
    contentDiv.innerHTML = "";

    const isUrdu = currentLang === 'urdu';
    document.body.style.direction = isUrdu ? 'rtl' : 'ltr';
    document.body.style.textAlign = isUrdu ? 'right' : 'left';
    if (isUrdu) {
        document.body.classList.add("urdu");
    } else {
        document.body.classList.remove("urdu");
    }

    updateNavFooter(isUrdu);

    langData.sections.forEach(sec => {
        const div = document.createElement("div");
        div.className = "section";
        div.innerHTML = `
            <h2>${sec.heading}</h2>
            <p style="white-space:pre-line;">${sec.content}</p>
        `;
        contentDiv.appendChild(div);
    });
}