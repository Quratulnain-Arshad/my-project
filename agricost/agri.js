let lang = "en"; 
let crops = {};

fetch("agri.json")
.then(res => res.json())
.then(data => crops = data.crops);

document.getElementById("toggleBtn").addEventListener("click", ()=>{
    lang = (lang === "en") ? "ur" : "en";
    document.getElementById("toggleBtn").innerText =
        (lang === "en") ? "اردو" : "English";

    const crop = document.getElementById("cropSelect").value;
    if(crop) showData(crop);
});


document.getElementById("cropSelect").addEventListener("change", (e)=>{
    const crop = e.target.value;
    if(crop) showData(crop);
});


function showData(cropKey){
    const c = crops[cropKey];

    document.getElementById("title").innerText = c["name_"+lang];

    document.getElementById("cropData").innerHTML = `
        <p><b>${(lang==="en")?"Cost":"لاگت"}:</b> ${c["cost_"+lang]}</p>
        <p><b>${(lang==="en")?"Yield":"اوسط پیداوار"}:</b> ${c["yield_"+lang]}</p>
        <p><b>${(lang==="en")?"Market Rate":"بازار ریٹ"}:</b> ${c["rate_"+lang]}</p>
        <p><b>${(lang==="en")?"Income":"آمدنی"}:</b> ${c["income_"+lang]}</p>
        <p><b>${(lang==="en")?"Profit":"منافع"}:</b> ${c["profit_"+lang]}</p>
    `;
}