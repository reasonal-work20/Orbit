/** Default Value */

async function getMap(parameters) {
    const response = await fetch('/Orbit/client/src/services/campus-navigation-service.php?' + parameters);
    var result = await response.json();
    return result;
}

async function getLocationList(parameters) {
    const response = await fetch('/Orbit/client/src/services/campus-navigation-service.php?' + parameters);
    var result = await response.json();
    var locationList = result.result;
    return locationList;
}

function locationOption(locationList) {
    htmlText = "<option value='' disabled selected>Select an option</option>\n";
    for (var location of locationList) {
        htmlText += `<option value='${location.locationID}'>${location.name}</option>\n`;
    }
    document.getElementById('location').innerHTML = htmlText;
}

async function init() {
    var parameters = "mode=default&floor=3&getMap=#";
    var mapList = await getMap(parameters);
    document.getElementById('map').innerHTML = mapList.svg[0];
    parameters = "floor=&type=&getLocation=#";
    var locationList = await getLocationList(parameters);
    locationOption(locationList);
} 
init();

const levelSelector = document.getElementById("level");
levelSelector.addEventListener("change", async function(event) {
    var floor = document.getElementById("level").value;
    document.getElementById("type").value = "";
    var parameters = `mode=default&floor=${floor}&getMap=#`;
    var mapList = await getMap(parameters);
    document.getElementById('map').innerHTML = mapList.svg[0];
    parameters = `floor=${floor}&type=&getLocation=#`;
    var locationList = await getLocationList(parameters);
    locationOption(locationList);
});

const typeSelector = document.getElementById("type");
typeSelector.addEventListener("change", async function(event) {
    var floor = document.getElementById("level").value;
    floor = floor == "All" ? "" : floor;
    var type = document.getElementById("type").value;
    type = type == "All" ? "" : type;
    var parameters = `floor=${floor}&type=${type}&getLocation=#`;
    console.log(parameters);
    var locationList = await getLocationList(parameters);
    locationOption(locationList);
});

const locationSelector = document.getElementById("location");
locationSelector.addEventListener("change", async function(event) {
    var location = document.getElementById("location").value;
    var parameters = `mode=point&point=${location}&getMap=#`;
    var mapList = await getMap(parameters);
    document.getElementById('map').innerHTML = mapList.svg[0];
});

async function findRoute() {
    loadingOverlay.style.display = 'flex';
    var start = document.getElementById('start').value;
    var end = document.getElementById('end').value;
    var route = document.getElementById('route').value;
    
    if (start == "" || end == "" || route == "") {
        loadingOverlay.style.display = 'none';
        return;
    }
    
    var parameters = `mode=route&start=${start}&end=${end}&route=${route}&getMap=#`;
    var result = await getMap(parameters);
    var path = result.path;
    var mapList = result.svg;
    
    var htmlText = "";
    for (var node of path) {
        var currentIndex = path.indexOf(node);
        if (currentIndex + 1 == path.length) {
            break;
        }
        if (node == "Walk") {
            continue;
        }
        if (path[currentIndex + 1] == "Walk") {
            nextNode = path[currentIndex + 2];
            htmlText += `<h3>Go from ${node} until ${nextNode}</h3>\n`;
        } else {
            nextNode = path[currentIndex + 1];
            htmlText += `<h3>Take the ${route} from ${node} to ${nextNode}</h3>`;
        }
    }
    for (var map of mapList) {
        htmlText += map;
    }
    document.getElementById('map').innerHTML = htmlText;
    loadingOverlay.style.display = 'none';
}