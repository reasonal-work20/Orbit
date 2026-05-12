const form = document.getElementById("search-form");
const selects = form.querySelectorAll("select");
selects.forEach(select => {
    select.addEventListener("change", async function(event) {
        floor = document.getElementById("level").value;
        type = document.getElementById("type").value;
        const response = await fetch ('/Orbit/client/src/services/campus-navigation-service.php?getLocation=true&floor=' + floor + "&type=" + type);
        let result = await response.json();
        data = result.result;
        htmlText = "";
        for (const row of data) {
            htmlText += `<button value='${row.locationID}' 
                        onclick="window.location.href='/Orbit/client/src/pages/campus-navigation/dashboard.php?getMap=true&mode=point&floor=${row.floor}&point=${row.locationID}'">
                        ${row.name}</button>`;
        }
        document.getElementById("locationResult").innerHTML = htmlText;
    }); 
});

function selectLocation(locationID) {
    closeModal("searchCampus");
}