let currentLang = "en";
let data;

async function loadData() {
    const response = await fetch("wheat.json");
    data = await response.json();
    updateContent();
}

function updateContent() {
    const langData = data[currentLang];

    document.getElementById("pageTitle").innerText = langData.title;
    document.getElementById("toggleBtn").innerText = langData.toggle;

    const grid = document.getElementById("topicsGrid");
    grid.innerHTML = "";

    langData.topics.forEach(topic => {
        grid.innerHTML += `
            <div class="card">
                <img src="${topic.image}" alt="">
                <h3>${topic.name}</h3>
            </div>
        `;
    });
}
document.getElementById("toggleBtn").addEventListener("click", () => {
    currentLang = currentLang === "en" ? "ur" : "en";
    updateContent();
});

loadData();
