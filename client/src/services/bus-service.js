async function updateBus(route) {
    if (route === "") {
        route = "LRT-BUKIT JALIL >> APU";
    }
    let response = await fetch ('/Orbit/server/routes/bus-route.php?fewSelectedRoute=' + route);
    let data = await response.json();
    timeList = data.time;
    text = "";
    for (const time of timeList) {
        text = text + '<div class="time-chip">' + time + "</div>";
    } 
    document.getElementById("bus-time-chips").innerHTML = text;
    document.getElementById("start").innerHTML = data.start;
    document.getElementById("destination").innerHTML = data.destination;
}

async function displayBus() {
    let response = await fetch ('/Orbit/server/routes/bus-route.php?all=true');
    let data = await response.json();
    busShuttle = data.schedule;
    text = "";
    for (const row of busShuttle) {
        timeData = "";
        for (const time of row[2]) {
            timeData = timeData + `
            <div class="time-slot">${time}</div>
            `;
        }
        text = text + `
        <div class="schedule-card">
            <div class="schedule-header blue-line" style="color: #007bff;">
                ${row[0]} → ${row[1]}
            </div>
            <div class="time-grid">
                ${timeData}
            </div>
        </div>
        `;
    }
    text = text + `
    <div class="note-text">Note: *All times are based on the Malaysian timezone (GMT +8)</div>
    `;
    document.getElementById("schedule-container").innerHTML = text;
}