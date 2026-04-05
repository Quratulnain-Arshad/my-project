let currentLang = "english";
let data = {};

document.addEventListener("DOMContentLoaded", () => {
    fetch("potatoinfo.json")
        .then(res => res.json())
        .then(json => {
            data = json;
            render();
        });

    document.getElementById("langButton")
        .addEventListener("click", toggleLang);
});

function render() {
    const langData = data[currentLang];

    document.getElementById("title").innerText = langData.title;

    const contentDiv = document.getElementById("content");
    contentDiv.innerHTML = "";

    langData.sections.forEach(sec => {
        const div = document.createElement("div");
        div.className = "section";

        div.innerHTML = `
            <h3>${sec.heading}</h3>
            <p>${sec.content.replace(/\n/g, "<br>")}</p>
        `;

        contentDiv.appendChild(div);
    });

    document.getElementById("langButton").innerText =
        currentLang === "english" ? "اردو" : "English";
}

function toggleLang() {
    currentLang = currentLang === "english" ? "urdu" : "english";
    render();
}