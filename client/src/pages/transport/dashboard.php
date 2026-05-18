<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

$_SESSION['currentPage'] = 'transport';
renderNavBar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit | Transport</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo STYLES; ?>/transport-global.css" />
    <link rel="stylesheet" href="<?php echo STYLES; ?>/global.css" />
    <link rel="stylesheet" href="<?php echo STYLES; ?>/nav-bar.css" />
    <link rel='icon' type='image/png' href="<?php echo ICONS; ?>/orbit-logo-square.svg" />
    <style>
        /* Dropdown/Select Styling */
        .bus-route-select { position: absolute; opacity: 0; cursor: pointer; width: 100%; height: 100%; appearance: none; -webkit-appearance: none; }
        .dropdown-trigger { position: relative; display: inline-flex; align-items: center; cursor: pointer; }
        .bus-route i.bx-chevron-down { font-size: 1.5rem; pointer-events: none; }

        /* Dashboard Styles */
        .bus-card { background: white; border-radius: 16px; padding: 40px; box-shadow: 0 10px 30px rgba(0,0,0,0.04); border-left: 8px solid #a29bfe; margin-bottom: 50px; }
        .bus-route { color: #9b59b6; font-weight: 900; font-size: 1.2rem; margin-bottom: 25px; display: flex; align-items: center; gap: 8px; text-transform: uppercase; }
        .time-chip { background: #f1f3f5; border: none; padding: 12px 24px; border-radius: 12px; font-weight: 800; margin-right: 12px; font-size: 0.9rem; cursor: pointer; }
        
        .carpool-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr)); gap: 30px; }
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

<script>
    async function checkActive() {
        let response = await fetch ('/Orbit/client/src/services/carpool-service.php?isActive=true');
        let data = await response.json();
        if (data.host) {
            window.location.href="<?php echo PAGES; ?>/transport/view-ride.php?carpool=" + data.carpoolID;
        } else if (data.requester) {
            window.location.href="<?php echo PAGES; ?>/transport/view-ride-passenger.php?carpool=" + data.carpoolID;
        }
    }
    checkActive();
</script>

<body>
    <div class="container">
        <div class="section-header">
            <h2>Upcoming Bus Trips</h2>
            <a href="<?php echo PAGES; ?>/transport/bus-shuttle.php" class="show-more">Show more</a>
        </div>
        
        <div class="bus-card">
            <div class="bus-route">
                <div id="start">APU Campus</div> <i class='bx bx-right-arrow-alt'></i> 
                <span id="dest-text" style="color: #9b59b6; margin-left: 5px;"><div id="destination">LRT Bukit Jalil</div></span>
                <div class="dropdown-trigger">
                    <i class='bx bx-chevron-down'></i>
                    <select class="bus-route-select" id="bus-select" onchange="updateBus(this.value)">
                        <option value="LRT-BUKIT JALIL >> APU">LRT-BUKIT JALIL >> APU</option>
                        <option value="M VERTICA >> APU">M VERTICA >> APU</option>
                        <option value="CITY OF GREEN >> APU">CITY OF GREEN >> APU</option>
                        <option value="BLOOMSVALE >> APU">BLOOMSVALE >> APU</option>
                        <option value="KUCHAI SENTRAL >> APU">KUCHAI SENTRAL >> APU</option>
                        <option value="D'IVO >> APU">D'IVO >> APU</option>
                        <option value="PARKHILL >> APU">PARKHILL >> APU</option>
                        <option value="HARMONY >> APU">HARMONY >> APU</option>
                        <option value="FORTUNE PARK >> APU">FORTUNE PARK >> APU</option>
                        <option value="KINGSTON HOTEL >> APU">KINGSTON HOTEL >> APU</option>
                        <option value="MAPLE >> APU">MAPLE >> APU</option>
                        <option value="APU >> FORTUNE PARK">APU >> FORTUNE PARK</option>
                        <option value="APU >> KINGSTON HOTEL">APU >> KINGSTON HOTEL</option>
                        <option value="APU >> LRT-BUKIT JALIL">APU >> LRT-BUKIT JALIL</option>
                        <option value="APU >> CITY OF GREEN">APU >> CITY OF GREEN</option>
                        <option value="APU >> KUCHAI SENTRAL">APU >> KUCHAI SENTRAL</option>
                        <option value="APU >> MAPLE">APU >> MAPLE</option>
                        <option value="APU >> D'IVO">APU >> D'IVO</option>
                        <option value="APU >> PARKHILL">APU >> PARKHILL</option>
                        <option value="APU >> MOSQUE">APU >> MOSQUE</option>
                        <option value="APU >> BLOOMSVALE">APU >> BLOOMSVALE</option>
                        <option value="APU >> HARMONY">APU >> HARMONY</option>
                        <option value="APU >> M VERTICA">APU >> M VERTICA</option>
                        <option value="MOSQUE >> APU">MOSQUE >> APU</option>
                    </select>
                </div>
            </div>
            <div class="time-chips" id="bus-time-chips" style="display:flex; flex-wrap:wrap;">
            </div>
            <p style="font-size: 0.7rem; color: #b2bec3; margin-top: 25px; font-weight: 600;">Note: *All times are based on the Malaysian timezone (GMT +8)</p>
        </div>

        <div class="section-header">
            <h2>Available Carpool</h2>
            <a href="<?php echo PAGES; ?>/transport/carpool-manage.php" class="show-more">Show more</a>
        </div>
        <div id="carpool-container" class="carpool-grid"></div>
    </div>

    <script src="<?php echo SERVICES; ?>/bus-service.js"></script>
    <script>
        updateBus("");
        async function filterRides() {
            const list = document.getElementById('carpool-container');

            let response = await fetch(`/Orbit/client/src/services/carpool-service.php?search=&filter=All&getAvailable=#`);
            let carpoolList = await response.json();
            list.innerHTML = '';

            if (carpoolList.length === 0) {
                list.innerHTML = `<p style="text-align:center; grid-column: 1/-1; color:#b2bec3; padding:50px;">No rides found.</p>`;
                return;
            }
            let count = 0;
            for (let carpool of carpoolList) {
                let format = { hour: "2-digit", minute: "2-digit", hour12: true };
                let date = new Date(carpool.time);
                list.innerHTML += `
                <div class='cp-card'>
                    <div class='cp-header'>
                        <div class='user-info'>
                            <div class='avatar'><img src='/Orbit/client/src/uploads/${carpool.picture}'></div>
                            <div>
                                <p style='font-weight:900;'>${carpool.name}</p>
                                <p style='font-size:0.7rem; color:#b2bec3;'>${carpool.hostID}</p>
                                <span class='badge ${carpool.type === 'VOLUNTEER' ? 'badge-volunteer' : 'badge-split'}'>${carpool.type}</span>
                            </div>
                        </div>
                        <div style='text-align:right'>
                            <p style='font-weight:900; font-size:1.2rem;'>${date.toLocaleTimeString("en-US", format)}</p>
                            <p style='font-size:0.65rem; color:#b2bec3; font-weight:800; text-transform:uppercase;'>Departure</p>
                        </div>
                    </div>
                    <div class='route-path'>
                        <div class='step'><i class='bx bxs-map-pin'></i><div><label>From</label><p>${carpool.start}</p></div></div>
                        <div class='step end'><i class='bx bxs-target-lock'></i><div><label>To</label><p>${carpool.destination}</p></div></div>
                    </div>
                    <div class='cp-footer'>
                        <div class='seats'><i class='bx bxs-user'></i> ${carpool.seat} Seats Left</div>
                        <button class='btn-view' onclick='window.location.href="<?php echo PAGES; ?>/transport/view-ride-passenger.php?carpool=${carpool.carpoolID}"'>View</button>
                    </div>
                </div>
                `;
                count += 1;
                if (count > 5) {
                    break;
                }
            }
        }
        filterRides();
    </script>
</body>
</html>