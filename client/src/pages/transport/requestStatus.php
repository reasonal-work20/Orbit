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
    <title>Orbit | Request Status</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transport-global.css">
    <style>
        .header-row { display: flex; align-items: center; gap: 20px; margin-bottom: 30px; }
        .header-row h1 { font-size: 1.4rem; color: #485460; font-weight: 800; text-transform: uppercase; }
        
        .back-btn { 
            background: white; border: none; width: 45px; height: 45px; 
            border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.08); 
            cursor: pointer; font-size: 1.5rem; display: flex; align-items: center; justify-content: center; 
        }

        /* Container matching the clean UI in the screenshot */
        .details-card {
            background: white;
            border-radius: 10px;
            padding: 40px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            min-height: 450px;
        }

        /* Blocks */
        .info-block { border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .bg-route { background: #e0f7fa; }
        .bg-car { background: #e8eaf6; }
        .bg-note { background: #fffde7; min-height: 160px; }
        .bg-contact { background: #e0f2f1; }

        .block-label { font-weight: 900; font-size: 0.75rem; color: #4b4b4b; margin-bottom: 10px; display: block; text-transform: uppercase; }
        
        /* Badges & Pills */
        .badge { display: inline-block; padding: 4px 12px; border-radius: 5px; font-size: 0.7rem; font-weight: 900; text-transform: uppercase; margin-top: 5px; }
        .badge-volunteer { background: #007bff; color: white; }
        .badge-split { background: #fff3e0; color: #e65100; }
        .seats-pill { background: white; padding: 6px 12px; border-radius: 8px; font-weight: 800; font-size: 0.8rem; display: flex; align-items: center; gap: 5px; }

        /* Bottom Buttons Group */
        .bottom-actions {
            grid-column: 1 / -1;
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .btn-status {
            padding: 15px 0;
            width: 280px;
            border-radius: 10px;
            font-weight: 900;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            text-transform: capitalize;
            transition: 0.3s;
        }

        /* Rejected / Cancel style */
        .btn-red { background: #ff0000; color: white; cursor: default; }
        .btn-cancel-active { background: #ff0000; color: white; cursor: pointer; }
        .btn-cancel-active:hover { background: #cc0000; }
        
        /* Navigation style */
        .btn-blue { background: #007bff; color: white; }
        .btn-blue:hover { background: #0056b3; }

        @media (max-width: 850px) { .details-card { grid-template-columns: 1fr; } }
    </style>
</head>
<body>

<div class="container">
    <div class="header-row">
        <button class="back-btn" onclick="window.location.href='<?php echo PAGES; ?>/transport/dashboard.php'"><i class='bx bx-chevron-left'></i></button>
        <h1>Ride Details</h1>
    </div>

    <div class="details-card" id="mainContent">
        <!-- JS renders content based on request state -->
    </div>
</div>

<script>
    // Logic to determine if we are showing a rejection or a cancellation option
    function renderStatusPage() {
        const rides = JSON.parse(localStorage.getItem('orbit_rides') || '[]');
        const index = localStorage.getItem('selected_ride_index');
        const ride = rides[index];

        // This 'requestState' would normally come from your database
        // Values: 'rejected' or 'pending'
        const requestState = localStorage.getItem('current_request_state') || 'rejected'; 

        if (!ride) {
            document.getElementById('mainContent').innerHTML = "<h2>Ride Not Found</h2>";
            return;
        }

        const badgeClass = ride.type === 'VOLUNTEER' ? 'badge-volunteer' : 'badge-split';

        // Left Side Content
        const leftSide = `
            <div>
                <div style="display:flex; justify-content:space-between; margin-bottom:10px;">
                    <div style="display:flex; gap:15px; align-items:center;">
                        <img src="${ride.avatar}" style="width:55px; height:55px; border-radius:50%; object-fit:cover;">
                        <div>
                            <p style="font-weight:900; font-size:1.1rem; margin:0;">${ride.driverName || ride.driver}</p>
                            <p style="font-size:0.75rem; color:#b2bec3; font-weight:700; margin:0;">${ride.driverID}</p>
                        </div>
                    </div>
                    <div style="text-align:right">
                        <p style="font-weight:900; font-size:1.3rem; margin:0;">${ride.time}</p>
                        <p style="font-size:0.65rem; color:#b2bec3; font-weight:800; margin:0;">DEPARTURE</p>
                    </div>
                </div>
                <div class="badge ${badgeClass}">${ride.type}</div>

                <div class="info-block bg-route" style="margin-top:20px;">
                    <p style="font-size:0.6rem; font-weight:900; color:#7f8c8d; margin-bottom:5px;">FROM</p>
                    <p style="font-weight:800; font-size:0.9rem; margin-bottom:15px;">${ride.from}</p>
                    <p style="font-size:0.6rem; font-weight:900; color:#7f8c8d; margin-bottom:5px;">TO</p>
                    <p style="font-weight:800; font-size:0.9rem;">${ride.to}</p>
                </div>

                <div class="info-block bg-car">
                    <span class="block-label">Car Details</span>
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <p style="font-weight:700; color:#485460; font-size:0.9rem;">${ride.carModel || 'White Proton (XYZ 1234)'}</p>
                        <div class="seats-pill"><i class='bx bxs-user'></i> ${ride.seats} Seats Left</div>
                    </div>
                </div>
            </div>
        `;

        // Right Side Content
        const rightSide = `
            <div>
                <div class="info-block bg-note">
                    <span class="block-label">Note</span>
                    <p style="font-size:0.9rem; line-height:1.6; color:#485460; font-weight:600;">${ride.note}</p>
                </div>
                <div class="info-block bg-contact">
                    <span class="block-label">Contact</span>
                    <p style="font-weight:700; margin-bottom:8px; font-size:0.9rem;"><i class='bx bxs-phone'></i> +60 123456789</p>
                    <p style="font-weight:700; font-size:0.9rem;"><i class='bx bxs-envelope'></i> ${ride.driverID}@mail.apu.edu.my</p>
                </div>
            </div>
        `;

        // Action Buttons (Dynamic)
        let actionButtons = '';
        if (requestState === 'rejected') {
            actionButtons = `
                <button class="btn-status btn-red">Rejected</button>
                <button class="btn-status btn-blue" onclick="window.location.href='transportDesktop.php'">Back to Carpool</button>
            `;
        } else {
            actionButtons = `
                <button class="btn-status btn-cancel-active" onclick="handleCancelRequest()">Cancel Request</button>
                <button class="btn-status btn-blue" onclick="window.location.href='transportDesktop.php'">Back to Dashboard</button>
            `;
        }

        document.getElementById('mainContent').innerHTML = leftSide + rightSide + `<div class="bottom-actions">${actionButtons}</div>`;
    }

    function handleCancelRequest() {
        if(confirm("Are you sure you want to cancel your request for this ride?")) {
            alert("Request Cancelled.");
            window.location.href = 'transportDesktop.php';
        }
    }

    window.onload = renderStatusPage;
</script>
</body>
</html>