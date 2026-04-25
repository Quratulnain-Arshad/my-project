let currentLang = "english";
let data = {};

document.addEventListener("DOMContentLoaded", () => {
    loadJSON();
    document.getElementById("langButton").addEventListener("click", toggleLanguage);
});

function loadJSON() {
    fetch("json/maizeinfo.json")
        .then(res => res.json())
        .then(json => {
            data = json;
            renderPage();
        });
}

function toggleLanguage() {
    currentLang = currentLang === "english" ? "urdu" : "english";

    const btn = document.getElementById("langButton");

    if (currentLang === "english") {
        btn.innerText = "اردو";
    } else {
        btn.innerText = "English";
    }

    renderPage();
}

function renderPage() {
    const langData = data[currentLang];

    document.getElementById("title").innerText = langData.title;

    const contentDiv = document.getElementById("content");
    contentDiv.innerHTML = "";
    if(currentLang==="urdu"){
        document.body.style.direction="rti";
        document.body.style.textAlign="right";
    }else{
        document.body.style.direction="ltr";
        document.body.style.textAlign="left";
    }

    langData.sections.forEach(sec => {
        const div = document.createElement("div");
        div.className = "section";

        div.innerHTML = `
            <h2>${sec.heading}</h2>
            <p style="white-space: pre-line;">${sec.content}</p>
        `;

        contentDiv.appendChild(div);
    });
}