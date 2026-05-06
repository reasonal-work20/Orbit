<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Transport</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transportglobal.css">
    <style>
        /* Dropdown/Select Styling */
        .bus-route-select { position: absolute; opacity: 0; cursor: pointer; width: 100%; height: 100%; appearance: none; -webkit-appearance: none; }
        .dropdown-trigger { position: relative; display: inline-flex; align-items: center; cursor: pointer; }
        .bus-route i.bx-chevron-down { font-size: 1.5rem; pointer-events: none; }

        /* Dashboard Styles */
        .bus-card { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border-left: 8px solid #a29bfe; margin-bottom: 50px; }
        .bus-route { color: #9b59b6; font-weight: 900; font-size: 1.2rem; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; text-transform: uppercase; }
        .time-chip { background: #f1f3f5; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; margin-right: 12px; font-size: 0.9rem; cursor: pointer; }
        .time-chip.active { background: white; border: 2px solid #2d3436; padding: 10px 22px; }
        
        .carpool-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px; }
        .cp-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); }
        .profile-row { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .user-meta { display: flex; gap: 15px; }
        .avatar { width: 60px; height: 60px; border-radius: 50%; background: #dfe6e9; overflow: hidden; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        
        .route-item { display: flex; gap: 15px; margin-bottom: 15px; align-items: flex-start; }
        .route-item i { font-size: 1.8rem; color: #007bff; }
        .route-item.end i { color: #eb4d4b; }
        .route-item label { font-size: 0.7rem; color: #b2bec3; font-weight: 800; display: block; text-transform: uppercase; }
        .route-item p { font-size: 0.9rem; font-weight: 700; color: #2d3436; }
        .cp-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 20px; }
        .btn-view { background: #007bff; color: white; border: none; padding: 12px 30px; border-radius: 10px; font-weight: 900; cursor: pointer; }
    </style>
</head>
<body>

    <header class="navigation-bar">
        <a href="transportDesktop.php" class="logo"><img src="orbit-logo.svg" alt="Orbit Logo"></a>
        <nav class="nav-links">
            <a href="#" class="nav-item"><i class='bx bx-home-alt'></i><span>Home</span></a>
            <a href="transportDesktop.php" class="nav-item active"><i class='bx bx-bus'></i><span>Transport</span></a>
            <a href="#" class="nav-item"><i class='bx bx-map-alt'></i><span>Directory</span></a>
            <a href="#" class="nav-item"><i class='bx bx-calendar'></i><span>Timetable</span></a>
            <a href="#" class="nav-item"><i class='bx bx-dots-vertical-rounded'></i><span>More</span></a>
        </nav>
    </header>

    <div class="container">
        <div class="section-header">
            <h2>Upcoming Bus Trips</h2>
            <a href="busShuttle.php" class="show-more">Show more</a>
        </div>
        
        <div class="bus-card">
            <div class="bus-route">
                APU Campus <i class='bx bx-right-arrow-alt'></i> 
                <span id="dest-text" style="color: #9b59b6; margin-left: 5px;">LRT Bukit Jalil</span>
                <div class="dropdown-trigger">
                    <i class='bx bx-chevron-down'></i>
                    <select class="bus-route-select" id="bus-select" onchange="updateBus()">
                        <option value="lrt">LRT Bukit Jalil</option>
                        <option value="mvertica">M Vertica</option>
                        <option value="cityofgreen">City of Green</option>
                        <option value="bloomsvale">Bloomsvale</option>
                    </select>
                </div>
            </div>
            <div class="time-chips" id="bus-time-chips"></div>
            <p style="font-size: 0.7rem; color: #b2bec3; margin-top: 25px; font-weight: 600;">Note: *All times are based on the Malaysian timezone (GMT +8)</p>
        </div>

        <div class="section-header">
            <h2>Upcoming Carpool</h2>
            <a href="carpoolManage.php" class="show-more">Show more</a>
        </div>
        <div id="carpool-container" class="carpool-grid"></div>
    </div>

    <script>
        const busSchedules = {
            lrt: ["7:45 A.M.", "8:00 A.M.", "8:15 A.M."],
            mvertica: ["8:30 A.M.", "9:30 A.M.", "10:30 A.M."],
            cityofgreen: ["7:50 A.M.", "8:50 A.M.", "9:50 A.M."],
            bloomsvale: ["8:10 A.M.", "9:10 A.M.", "10:10 A.M."]
        };

        function updateBus() {
            const select = document.getElementById('bus-select');
            const val = select.value;
            document.getElementById('dest-text').innerText = select.options[select.selectedIndex].text;
            const container = document.getElementById('bus-time-chips');
            container.innerHTML = busSchedules[val].map((time, index) => `
                <button class="time-chip ${index === 0 ? 'active' : ''}">${time}</button>
            `).join('');
        }

        function renderDashboard() {
            const rides = JSON.parse(localStorage.getItem('orbit_rides')) || [];
            const container = document.getElementById('carpool-container');
            
            if (rides.length === 0) {
                container.innerHTML = `<p style="color: #b2bec3; text-align: center; grid-column: 1/-1;">No rides available.</p>`;
                return;
            }

            container.innerHTML = rides.map((ride, index) => `
                <div class="cp-card">
                    <div class="profile-row">
                        <div class="user-meta">
                            <div class="avatar"><img src="${ride.avatar || 'https://i.pravatar.cc/150'}"></div>
                            <div>
                                <p style="font-weight: 900;">${ride.driverName || 'Alexander J.'}</p>
                                <p style="font-size: 0.75rem; color: #b2bec3;">${ride.driverID || 'TP000000'}</p>
                                <span class="badge-volunteer">${ride.type || 'Volunteer'}</span>
                            </div>
                        </div>
                        <div style="text-align: right;">
                            <p style="font-weight: 900; font-size: 1.2rem;">${ride.time}</p>
                            <p style="font-size: 0.6rem; color: #b2bec3; font-weight: 800;">DEPARTURE</p>
                        </div>
                    </div>
                    <div class="route-container">
                        <div class="route-item"><i class='bx bxs-map-pin'></i><div><label>From</label><p>${ride.from || ride.origin}</p></div></div>
                        <div class="route-item end"><i class='bx bxs-target-lock'></i><div><label>To</label><p>${ride.to || ride.destination}</p></div></div>
                    </div>
                    <div class="cp-footer">
                        <div class="seats-pill"><i class='bx bxs-user'></i> ${ride.seats} Seats Left</div>
                        <button class="btn-view" onclick="viewRide(${index})">View</button>
                    </div>
                </div>
            `).join('');
        }

        function viewRide(index) {
            localStorage.setItem('selected_ride_index', index);
            window.location.href = 'viewRide.php';
        }

        window.onload = () => { 
            updateBus(); 
            renderDashboard(); 
        };
    </script>
</body>
</html>