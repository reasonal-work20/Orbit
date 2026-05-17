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
    <title>Orbit | Ride Details (Driver)</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo STYLES; ?>/transport-global.css">
    <link rel="stylesheet" href="<?php echo STYLES; ?>/nav-bar.css">
    <style>
        body { background-color: #f8f9fa; margin: 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        
        .main-card { background: white; border-radius: 24px; padding: 50px; box-shadow: 0 10px 40px rgba(0,0,0,0.03); }
        
        /* Two Column Grid */
        .details-grid { display: grid; grid-template-columns: 1.2fr 1fr; gap: 40px; }
        .left-col, .right-col { display: flex; flex-direction: column; gap: 20px; }

        /* Driver Header Area */
        .driver-header { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #f1f2f6; padding-bottom: 15px; }
        .profile { display: flex; gap: 15px; align-items: center; }
        .profile img { width: 55px; height: 55px; border-radius: 50%; object-fit: cover; }
        .name-id h3 { margin: 0; font-size: 1.1rem; color: #2d3436; font-weight: 700; }
        .name-id p { margin: 0; font-size: 0.8rem; color: #b2bec3; font-weight: 600; }

        .departure-info { text-align: right; }
        .departure-info h2 { margin: 0; font-size: 1.8rem; color: #2d3436; font-weight: 800; }
        .departure-info p { margin: 0; font-size: 0.7rem; color: #b2bec3; font-weight: 800; text-transform: uppercase; }

        .fare-tag { background: #fff9db; color: #f08c00; font-size: 0.65rem; font-weight: 900; padding: 5px 12px; border-radius: 6px; display: inline-block; margin-top: 10px; text-transform: uppercase; border: 1px solid #ffe066; }

        /* Route Styles */
        .route-box { background: #e3f2fd; border-radius: 16px; padding: 25px; }
        .route-point { display: flex; align-items: flex-start; gap: 15px; margin-bottom: 20px; }
        .route-point i { font-size: 1.6rem; color: #007bff; }
        .route-point.end i { color: #eb4d4b; }
        .route-point label { font-size: 0.7rem; color: #74b9ff; font-weight: 800; display: block; text-transform: uppercase; }
        .route-point p { font-size: 0.95rem; font-weight: 700; color: #2d3436; margin: 2px 0 0 0; }

        /* Vehicle Info */
        .car-details-box { background: #e8eaf6; border-radius: 16px; padding: 25px; display: flex; justify-content: space-between; align-items: center; }
        .car-info label { font-weight: 800; font-size: 0.75rem; color: #7986cb; display: block; margin-bottom: 5px; text-transform: uppercase; }
        .car-info p { color: #2d3436; font-size: 0.9rem; font-weight: 700; margin: 0; }
        .seats-left { background: rgba(255,255,255,0.7); padding: 10px 18px; border-radius: 12px; font-weight: 700; font-size: 0.85rem; display: flex; align-items: center; gap: 8px; color: #2d3436; }

        /* Right Column */
        .note-box { background: #fffde7; border-radius: 16px; padding: 25px; border: 1px solid #fff9c4; }
        .note-box label { font-weight: 800; font-size: 0.8rem; color: #2d3436; display: block; margin-bottom: 10px; text-transform: uppercase; }
        .note-box p { font-size: 0.85rem; color: #636e72; line-height: 1.6; margin: 0; }

        .requests-box { background: #e1f5fe; border-radius: 16px; padding: 25px; min-height: 280px; }
        .requests-box label { font-weight: 800; font-size: 0.85rem; color: #2d3436; display: block; margin-bottom: 20px; text-transform: uppercase; }
        .request-item { display: flex; justify-content: space-between; align-items: center; margin-bottom: 18px; padding-bottom: 10px; border-bottom: 1px solid rgba(0,0,0,0.03); }
        .request-name { font-size: 0.9rem; font-weight: 600; color: #444; }
        
        .req-actions { display: flex; gap: 10px; }
        .btn-action { width: 32px; height: 32px; border-radius: 8px; border: none; color: white; display: flex; align-items: center; justify-content: center; cursor: pointer; transition: 0.2s; }
        .btn-reject { background: #ff0000; }
        .btn-approve { background: #007bff; }

        /* Footer Action Buttons */
        .footer-actions { display: flex; justify-content: center; gap: 20px; margin-top: 50px; }
        .btn-cancel { background: #ff0000; color: white; border: none; padding: 18px 80px; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 1rem; transition: 0.3s; }
        .btn-waiting { background: #007bff; color: white; border: none; padding: 18px 80px; border-radius: 12px; font-weight: 800; cursor: pointer; font-size: 1rem; display: flex; align-items: center; justify-content: center; gap: 10px; transition: 0.3s; min-width: 250px; }
        
        .btn-cancel:hover, .btn-waiting:hover { transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <div class="container">
        <h2 style="margin-bottom: 25px; color: #2d3436; font-weight: 900; letter-spacing: -0.5px;">RIDE DETAILS</h2>

        <div class="main-card">
            <div class="details-grid">
                <div class="left-col">
                    <div class="driver-header">
                        <div class="profile">
                            <img src="" id="profile">
                            <div class="name-id">
                                <h3 id="name"></h3>
                                <p id="hostID"></p>
                            </div>
                        </div>
                        <div class="departure-info">
                            <h2 id="time"></h2>
                            <p>Departure</p>
                        </div>
                    </div>
                    <div><span class="fare-tag" id="type"></span></div>

                    <div class="route-box">
                        <div class="route-point">
                            <i class='bx bxs-map-pin'></i>
                            <div><label>From</label><p id="start"></p></div>
                        </div>
                        <div class="route-point end">
                            <i class='bx bxs-target-lock'></i>
                            <div><label>To</label><p id="destination"></p></div>
                        </div>
                    </div>

                    <div class="car-details-box">
                        <div class="car-info">
                            <label>Car Details</label>
                            <p id="car"></p>
                        </div>
                        <div class="seats-left"><i class='bx bxs-user'></i><div id="capacity"></div></div>
                    </div>
                </div>

                <div class="right-col">
                    <div class="note-box">
                        <label>Note</label>
                        <p id="note"></p>
                    </div>

                    <div class="requests-box">
                        <label>Requests</label>
                        <div id="request-list">
                        </div>
                    </div>
                </div>
            </div>

            <form method="post" action="<?php echo SERVICES; ?>/carpool-service.php" class="footer-actions">
                <button class="btn-cancel" name="cancelRide" type="submit">Cancel Ride</button>
                <select class="btn-waiting" id="statusBtn" onclick="">
                    <option value="Waiting">Waiting</option>
                    <option value="Full">Full</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Completed">Completed</option>
                </select>
            </form>
        </div>
    </div>

    <script>
        (async () => {
            let userID = <?php echo $_SESSION['userID'] ?>;
            let response = await fetch('/Orbit/client/src/services/carpool-service.php?host=true');
            let data = await response.json();
            document.getElementById("profile").src = "<?php echo UPLOADS; ?>/" + data.picture;
            document.getElementById("name").innerHTML = data.name;
            document.getElementById("hostID").innerHTML = data.hostID;
            let format = { hour: "2-digit", minute: "2-digit", hour12: true };
            let date = new Date(data.time);
            document.getElementById("time").innerHTML = date.toLocaleTimeString("en-US", format);
            document.getElementById("type").innerHTML = data.type;
            document.getElementById("start").innerHTML = data.start;
            document.getElementById("destination").innerHTML = data.destination;
            document.getElementById("capacity").innerHTML = data.seat + " Seats Left";
            if (data.carModel) {
                document.getElementById("car").innerHTML = data.carModel + " " + data.carColour + " (" + data.carPlate + ")";
            }
            document.getElementById("note").innerHTML = data.note;
            document.getElementById("statusBtn").value = data.status;
            text = ""
            for (const request of data.requester) {
                let button = "";
                if (request.approval === "Approved") {
                    button = "";
                } else {
                    button = `<button type='submit' class='btn-action btn-reject' name='rejectRequest'><i class='bx bx-x'></i></button>
                              <button type='submit' class='btn-action btn-approve' name='approveRequest'><i class='bx bx-check'></i></button>`;
                }
                text = text + `<div class="request-item">
                                <span class="request-name">${request.name}</span>
                                <form class="req-actions" action = '<?php echo SERVICES; ?>/carpool-service.php' method='post'>
                                    <input type="hidden" name="requesterID" value="${request.requestID}" />
                                    <input type="hidden" name="carpoolID" value="${data.carpoolID}" />
                                    ${button}    
                                </form>
                            </div>`;
            }
            document.getElementById("request-list").innerHTML = text;
        })();

        let statusSelector = document.getElementById("statusBtn");
        let carpoolID = <?php echo $_GET['carpool'] ?>;
        statusSelector.addEventListener("change", async function(event) {
            let status = this.value;
            let response = await fetch(`/Orbit/client/src/services/carpool-service.php?carpoolID=${carpoolID}&status=${status}&updateRide=#`);
            let check = await response.json();
            console.log(check);
            if (check.redirect) {
                window.location.href='/Orbit/client/src/pages/transport/dashboard.php';
            }
        });
    </script>
</body>
</html>