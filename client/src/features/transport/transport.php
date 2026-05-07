<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . COMPONENTS . '/nav-bar.php';

$_SESSION['currentPage'] = 'transport';
renderNavBar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Transport</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo STYLES ?>/transport-global.css" />
    <link rel="stylesheet" href="<?php echo STYLES ?>/nav-bar.css" />
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

<script>
    async function checkActive() {
        let response = await fetch ('/Orbit/client/src/services/carpool-service.php?isActive=true');
        let data = await response.json();
        if (data.host) {
            window.location.href="<?php echo FEATURES; ?>/transport/view-ride.php?carpool=" + data.carpoolID;
        } else if (data.requester) {
            window.location.href="<?php echo FEATURES; ?>/transport/view-ride-passenger.php?carpool=" + data.carpoolID;
        }
    }
    checkActive();
</script>

<body>
    <div class="container">
        <div class="section-header">
            <h2>Upcoming Bus Trips</h2>
            <a href="<?php echo FEATURES; ?>/transport/bus-shuttle.php" class="show-more">Show more</a>
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
            <h2>Upcoming Carpool</h2>
            <a href="<?php echo FEATURES; ?>/transport/carpool-manage.php" class="show-more">Show more</a>
        </div>
        <div id="carpool-container" class="carpool-grid"></div>
    </div>

    <script src="<?php echo SERVICES; ?>/bus-service.js"></script>
    <script>updateBus("");</script>
</body>
</html>