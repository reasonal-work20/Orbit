<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';

if (!isset($_SESSION['userID'])) {
    header("Location: " . INDEX);
    exit();
}

if (isset($_SESSION['error'])) {
    echo '<div class="error-message">' . htmlspecialchars($_SESSION['error']) . '</div>';
    unset($_SESSION['error']);
}

$_SESSION['currentPage'] = 'transport';
renderNavBar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Ride Details (Passenger)</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo STYLES; ?>/global.css">
    <link rel="stylesheet" href="<?php echo STYLES; ?>/transport-global.css">
    <link rel="stylesheet" href="<?php echo STYLES; ?>/nav-bar.css">
    
    <style>
        body { background-color: #f8f9fa; margin: 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        
        /* Navigation & Back Button */
        .back-btn { background: white; border: none; padding: 10px 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); cursor: pointer; margin-bottom: 20px; transition: 0.2s; display: flex; align-items: center; justify-content: center; width: 45px; height: 45px; }
        .back-btn i { font-size: 1.5rem; color: #2d3436; }
        
        .main-card { background: white; border-radius: 24px; padding: 60px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); min-height: 500px; position: relative; }
        
        /* Layout Grid */
        .details-grid { display: grid; grid-template-columns: 1.1fr 1fr; gap: 40px; margin-bottom: 40px; }
        .left-col, .right-col { display: flex; flex-direction: column; gap: 20px; }

        /* Header Info */
        .driver-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f2f6; padding-bottom: 15px; }
        .profile { display: flex; gap: 15px; align-items: center; }
        .profile img { width: 55px; height: 55px; border-radius: 50%; object-fit: cover; }
        .name-id h3 { margin: 0; font-size: 1.1rem; color: #2d3436; font-weight: 700; }
        .name-id p { margin: 0; font-size: 0.8rem; color: #b2bec3; font-weight: 600; }

        .departure-info { text-align: right; }
        .departure-info h2 { margin: 0; font-size: 1.8rem; color: #2d3436; font-weight: 800; }
        .departure-info p { margin: 0; font-size: 0.7rem; color: #b2bec3; font-weight: 800; text-transform: uppercase; }

        .fare-tag { background: #fff9db; color: #f08c00; font-size: 0.65rem; font-weight: 900; padding: 5px 12px; border-radius: 6px; display: inline-block; margin-top: 10px; text-transform: uppercase; border: 1px solid #ffe066; }

        /* Route Box */
        .route-box { background: #e0f2f1; border-radius: 16px; padding: 20px; }
        .route-point { display: flex; align-items: flex-start; gap: 15px; margin-bottom: 15px; }
        .route-point:last-child { margin-bottom: 0; }
        .route-point i { font-size: 1.4rem; color: #007bff; }
        .route-point.end i { color: #eb4d4b; }
        .route-point label { font-size: 0.65rem; color: #636e72; font-weight: 700; display: block; text-transform: uppercase; }
        .route-point p { font-size: 0.9rem; font-weight: 700; color: #2d3436; margin: 2px 0 0 0; }

        /* Vehicle & Seats */
        .car-details-box { background: #e8eaf6; border-radius: 16px; padding: 25px; display: flex; justify-content: space-between; align-items: center; }
        .car-info label { font-weight: 800; font-size: 0.7rem; color: #7986cb; display: block; margin-bottom: 5px; text-transform: uppercase; }
        .car-info p { color: #2d3436; font-size: 0.85rem; font-weight: 700; margin: 0; }
        .seats-left { background: rgba(255,255,255,0.7); padding: 8px 15px; border-radius: 10px; font-weight: 700; font-size: 0.8rem; display: flex; align-items: center; gap: 8px; color: #2d3436; }

        /* Note Box (Yellow) */
        .note-box { background: #fffde7; border-radius: 16px; padding: 25px; border: 1px solid #fff9c4; flex-grow: 1; }
        .note-box label { font-weight: 800; font-size: 0.75rem; color: #2d3436; display: block; margin-bottom: 10px; text-transform: uppercase; }
        .note-box p { font-size: 0.85rem; color: #636e72; line-height: 1.5; margin: 0; }

        /* Contact Box (Light Blue) */
        .contact-box { background: #e1f5fe; border-radius: 16px; padding: 20px; }
        .contact-box label { font-weight: 800; font-size: 0.75rem; color: #2d3436; display: block; margin-bottom: 8px; text-transform: uppercase; }
        .contact-box p { font-size: 0.85rem; color: #2d3436; font-weight: 600; margin: 2px 0; }

        /* Footer Request Button */
        .footer-actions { display: flex; justify-content: center; margin-top: 20px; }
        .btn-request { background: #007bff; color: white; border: none; padding: 18px 120px; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 1.1rem; transition: 0.3s; width: 100%; max-width: 400px; }
        .btn-request:hover { transform: translateY(-3px); background: #0069d9; box-shadow: 0 8px 20px rgba(0,123,255,0.3); }
        .btn-request:active { transform: translateY(0); }
    </style>
</head>
<body>
    <div class="container">
        <button class="back-btn" onclick="window.location.href='<?php echo PAGES; ?>/transport/carpool-manage.php'"><i class='bx'>&#xea4d</i></button>
        <h2 style="margin-bottom: 25px; color: #2d3436; font-weight: 900; letter-spacing: -0.5px; text-transform: uppercase;">RIDE DETAILS</h2>

        <div class="main-card">
            <div class="details-grid">
                
                <!-- Left Column -->
                <div class="left-col">
                    <div class="driver-header">
                        <div class="profile">
                            <img src="" id="picture">
                            <div class="name-id">
                                <h3 id="name"></h3>
                                <p id="hostId"></p>
                            </div>
                        </div>
                        <div class="departure-info">
                            <h2 id="time"></h2>
                            <p>Departure</p>
                        </div>
                    </div>
                    <div><span class="fare-tag"><p id="type"></p></span></div>

                    <div class="route-box">
                        <div class="route-point">
                            <i class='bx'>&#xee19</i>
                            <div><label>From</label><p id="start"></p></div>
                        </div>
                        <div class="route-point end">
                            <i class='bx'>&#xec3d</i>
                            <div><label>To</label><p id="destination"></p></div>
                        </div>
                    </div>

                    <div class="car-details-box">
                        <div class="car-info">
                            <label>Car Details</label>
                            <p id="car">White Proton (XYZ 1234)</p>
                        </div>
                        <div class="seats-left"><i class='bx'>&#xeee1</i><div id="seat"></div></div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-col">
                    <div class="note-box">
                        <label>Note</label>
                        <p id="note"></p>
                    </div>

                    <div class="contact-box">
                        <label>Contact</label>
                        <p id="contact"></p>
                        <p id="email"></p>
                    </div>
                </div>

            </div>

            <!-- Action Button -->
            <div class="footer-actions">
                <button class="btn-request" id="requestBtn" onclick="handleRequest()" style="display:none;">Request Ride</button>
                <button class="btn-request" id="cancelBtn" onclick="window.location.href='/Orbit/client/src/services/carpool-service.php?cancelRequest=#'" style="background-color: #ff0000; display:none;">Cancel Ride</button>
            </div>
        </div>
    </div>

    <script>
        async function handleRequest() {
            // Visual feedback for the button
            const btn = document.getElementById('requestBtn');    
            let response = await fetch(`/Orbit/client/src/services/carpool-service.php?carpoolID=<?php echo $_GET['carpool']; ?>&newRequest=#`);
            response = response.json();
            let error = response.error;

            if (error) {
                return;
            }
            btn.innerHTML = "Request Sent <i class='bx bxs-check-circle'></i>";
            btn.style.background = "#2ecc71";
            btn.disabled = true;
            
            setTimeout(() => {
                window.location.href = '/Orbit/client/src/pages/transport/view-ride-passenger.php?carpool=<?php echo $_GET['carpool']; ?>';
            }, 1000);
        }

        async function load() {
            let response = await fetch('/Orbit/client/src/services/carpool-service.php?requester=<?php echo $_GET['carpool']; ?>');
            let data = await response.json();
            if (!data.picture) {
                window.location.href = '/Orbit/client/src/pages/transport/carpool-manage.php';
            }
            document.getElementById("picture").src = "<?php echo UPLOADS; ?>/" + data.picture;
            document.getElementById("name").innerHTML = data.name;
            console.log(data);
            document.getElementById("hostId").innerHTML = data.hostID;
            let format = { hour: "2-digit", minute: "2-digit", hour12: true };
            let date = new Date(data.time);
            document.getElementById("time").innerHTML = date.toLocaleTimeString("en-US", format);
            document.getElementById("type").innerHTML = data.type;
            document.getElementById("start").innerHTML = data.start;
            document.getElementById("destination").innerHTML = data.destination;
            document.getElementById("seat").innerHTML = data.seat + " Seats Left";
            if (data.carModel) {
                document.getElementById("car").innerHTML = data.carModel + " " + data.carColour + " (" + data.carPlate + ")";
            }
            document.getElementById("note").innerHTML = data.note;
            document.getElementById("contact").innerHTML = data.phone;
            document.getElementById("email").innerHTML = data.email;

            response = await fetch('/Orbit/client/src/services/carpool-service.php?isActive=#');
            data = await response.json();
            if (data.requester) {
                document.getElementById("cancelBtn").style.display = "block";
            } else {
                document.getElementById("requestBtn").style.display = "block";
            }
        };
        load();
    </script>
</body>
</html>