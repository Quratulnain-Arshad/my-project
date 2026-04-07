let currentLang = "english";
let data = {};

fetch("wheatinfo.json")
  .then(res => res.json())
  .then(json => {
    data = json;
    render();
  });

document.getElementById("langBtn").addEventListener("click", () => {
  currentLang = currentLang === "english" ? "urdu" : "english";
  document.getElementById("langBtn").innerText =
    currentLang === "english" ? "اردو" : "English";
  render();
});

function render() {
  const contentDiv = document.getElementById("content");
  const title = document.getElementById("title");

  contentDiv.innerHTML = "";

  title.innerText = data[currentLang].title;

  if (currentLang === "urdu") {
    document.body.classList.add("urdu");
  } else {
    document.body.classList.remove("urdu");
  }

  data[currentLang].sections.forEach(sec => {
    const div = document.createElement("div");
    div.classList.add("section");

    div.innerHTML = `
      <h2>${sec.heading}</h2>
      <p>${sec.content.replace(/\n/g, "<br>")}</p>
    `;

    contentDiv.appendChild(div);
  });
}