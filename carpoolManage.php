<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Carpool Management</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transportglobal.css">
    <style>
        .filter-tabs { background: #e9ecef; border-radius: 12px; display: flex; padding: 5px; margin-bottom: 30px; }
        .tab-item { flex: 1; display: flex; flex-direction: column; align-items: center; padding: 15px; cursor: pointer; color: #495057; font-weight: 700; font-size: 0.8rem; border-radius: 10px; }
        .tab-item.active { background: white; color: #2d3436; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
        .tab-divider { width: 1px; background: #dee2e6; margin: 10px 0; }

        .search-action-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px; }
        .search-bar { background: white; flex: 1; display: flex; align-items: center; padding: 0 20px; height: 55px; border-radius: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.03); }
        .search-bar input { border: none; outline: none; width: 100%; margin-left: 10px; font-weight: 500; }

        .btn-group { display: flex; gap: 10px; }
        .btn-my-rides { background: #485460; color: white; border: none; padding: 0 25px; height: 45px; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .btn-post { background: #007bff; color: white; border: none; padding: 0 25px; height: 45px; border-radius: 8px; font-weight: 700; cursor: pointer; text-decoration: none; display: flex; align-items: center; }

        .carpool-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 25px; }
        .cp-card { background: white; border-radius: 20px; padding: 30px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
        .cp-header { display: flex; justify-content: space-between; margin-bottom: 20px; }
        .user-info { display: flex; gap: 15px; align-items: center; }
        .avatar { width: 55px; height: 55px; border-radius: 50%; background: #dfe6e9; overflow: hidden; }
        .avatar img { width: 100%; height: 100%; object-fit: cover; }
        
        .badge { font-size: 0.65rem; padding: 4px 10px; border-radius: 6px; font-weight: 900; text-transform: uppercase; margin-top: 5px; display: inline-block; }
        .badge-volunteer { background: #e3f2fd; color: #1e88e5; }
        .badge-split { background: #fff3e0; color: #e65100; }

        .route-path { margin: 25px 0; }
        .step { display: flex; gap: 15px; margin-bottom: 15px; }
        .step i { font-size: 1.8rem; color: #007bff; }
        .step.end i { color: #ff4d4d; }
        .step label { font-size: 0.7rem; color: #b2bec3; font-weight: 800; display: block; }
        .step p { font-size: 0.9rem; font-weight: 700; }

        .cp-footer { display: flex; justify-content: space-between; align-items: center; }
        .seats { background: #f1f3f5; padding: 10px 18px; border-radius: 12px; font-size: 0.85rem; font-weight: 800; color: #636e72; }
        .btn-view { background: #007bff; color: white; border: none; padding: 12px 35px; border-radius: 10px; font-weight: 900; cursor: pointer; }
    </style>
</head>
<body>

<header class="navigation-bar">
    <a href="#" class="logo">ORBIT</a>
    <nav class="nav-links">
        <a href="#" class="nav-item"><i class='bx bx-home-alt'></i><span>Home</span></a>
        <!-- FIXED REDIRECT -->
        <a href="transportDesktop.php" class="nav-item active"><i class='bx bx-bus'></i><span>Transport</span></a>
        <a href="#" class="nav-item"><i class='bx bx-map-alt'></i><span>Directory</span></a>
        <a href="#" class="nav-item"><i class='bx bx-calendar'></i><span>Timetable</span></a>
        <a href="#" class="nav-item"><i class='bx bx-dots-vertical-rounded'></i><span>More</span></a>
    </nav>
</header>

<div class="container">
    <!-- FIXED BACK BUTTON -->
    <button class="back-btn" style="background: white; border: none; width: 45px; height: 45px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); cursor: pointer; margin-bottom: 25px;" onclick="location.href='transportDesktop.php'">
        <i class='bx bx-chevron-left'></i>
    </button>

    <div class="filter-tabs">
        <div class="tab-item active" onclick="setFilter('ALL', this)"><i class='bx bx-car'></i>All Rides</div>
        <div class="tab-divider"></div>
        <div class="tab-item" onclick="setFilter('VOLUNTEER', this)"><i class='bx bx-user-voice'></i>Volunteers</div>
        <div class="tab-divider"></div>
        <div class="tab-item" onclick="setFilter('SPLIT FARE', this)"><i class='bx bx-dollar-circle'></i>Split Fare</div>
    </div>

    <div class="search-action-row">
        <div class="search-bar">
            <i class='bx bx-search'></i>
            <input type="text" id="searchInput" placeholder="Search by landmark or location" onkeyup="filterRides()">
        </div>
        <div class="btn-group">
            <button class="btn-my-rides">My Rides</button>
            <a href="createRide.php" class="btn-post">+ Post Ride</a>
        </div>
    </div>

    <div id="carpool-list" class="carpool-grid"></div>
</div>

<script>
    let activeFilter = 'ALL';

    function setFilter(filter, element) {
        activeFilter = filter;
        document.querySelectorAll('.tab-item').forEach(tab => tab.classList.remove('active'));
        element.classList.add('active');
        filterRides();
    }

    // UPDATED: Finds the correct index in the MASTER list
    function openRideDetails(rideID) {
        const rides = JSON.parse(localStorage.getItem('orbit_rides') || '[]');
        const globalIndex = rides.findIndex(r => r.id === rideID);
        
        if (globalIndex !== -1) {
            localStorage.setItem('selected_ride_index', globalIndex);
            location.href = 'viewRide.php';
        }
    }

    function filterRides() {
        const query = document.getElementById('searchInput').value.toLowerCase();
        const rides = JSON.parse(localStorage.getItem('orbit_rides') || '[]');
        const list = document.getElementById('carpool-list');

        const filtered = rides.filter(ride => {
            // Using || for flexible data names
            const fromLoc = (ride.from || ride.origin || "").toLowerCase();
            const toLoc = (ride.to || ride.destination || "").toLowerCase();
            
            const matchesSearch = fromLoc.includes(query) || toLoc.includes(query);
            const matchesFilter = activeFilter === 'ALL' || ride.type === activeFilter;
            return matchesSearch && matchesFilter;
        });

        if(filtered.length === 0) {
            list.innerHTML = `<p style="text-align:center; grid-column: 1/-1; color:#b2bec3; padding:50px;">No rides found.</p>`;
            return;
        }

        list.innerHTML = filtered.map((ride) => `
            <div class="cp-card">
                <div class="cp-header">
                    <div class="user-info">
                        <div class="avatar"><img src="${ride.avatar || ''}"></div>
                        <div>
                            <p style="font-weight:900;">${ride.driver || ride.driverName}</p>
                            <p style="font-size:0.7rem; color:#b2bec3;">${ride.id}</p>
                            <span class="badge ${ride.type === 'VOLUNTEER' ? 'badge-volunteer' : 'badge-split'}">${ride.type || 'VOLUNTEER'}</span>
                        </div>
                    </div>
                    <div style="text-align:right">
                        <p style="font-weight:900; font-size:1.2rem;">${ride.time}</p>
                        <p style="font-size:0.65rem; color:#b2bec3; font-weight:800; text-transform:uppercase;">Departure</p>
                    </div>
                </div>
                <div class="route-path">
                    <div class="step"><i class='bx bxs-map-pin'></i><div><label>From</label><p>${ride.from || ride.origin}</p></div></div>
                    <div class="step end"><i class='bx bxs-target-lock'></i><div><label>To</label><p>${ride.to || ride.destination}</p></div></div>
                </div>
                <div class="cp-footer">
                    <div class="seats"><i class='bx bxs-user'></i> ${ride.seats} Seats Left</div>
                    <!-- PASSING RIDE ID TO FIND CORRECT GLOBAL INDEX -->
                    <button class="btn-view" onclick="openRideDetails('${ride.id}')">View</button>
                </div>
            </div>
        `).join('');
    }

    window.onload = filterRides;
</script>
</body>
</html>