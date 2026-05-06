<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Ride Details (Driver)</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transportglobal.css">
    <style>
        body { background-color: #f8f9fa; margin: 0; font-family: 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; }
        .container { max-width: 1100px; margin: 40px auto; padding: 0 20px; }
        
        /* Navigation & Back Button */
        .back-btn { background: white; border: none; padding: 10px 15px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); cursor: pointer; margin-bottom: 20px; transition: 0.2s; }
        .back-btn:hover { background: #f1f2f6; }
        
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
        <button class="back-btn" onclick="history.back()"><i class='bx bx-chevron-left'></i></button>
        <h2 style="margin-bottom: 25px; color: #2d3436; font-weight: 900; letter-spacing: -0.5px;">RIDE DETAILS</h2>

        <div class="main-card">
            <div class="details-grid">
                <div class="left-col">
                    <div class="driver-header">
                        <div class="profile">
                            <img src="https://i.pravatar.cc/150?u=marcus" alt="Marcus Chen">
                            <div class="name-id">
                                <h3>Marcus Chen</h3>
                                <p>TP000001</p>
                            </div>
                        </div>
                        <div class="departure-info">
                            <h2>08:15</h2>
                            <p>Departure</p>
                        </div>
                    </div>
                    <div><span class="fare-tag">Split Fare</span></div>

                    <div class="route-box">
                        <div class="route-point">
                            <i class='bx bxs-map-pin'></i>
                            <div><label>From</label><p>LRT Bukit Jalil</p></div>
                        </div>
                        <div class="route-point end">
                            <i class='bx bxs-target-lock'></i>
                            <div><label>To</label><p>Asia Pacific University (APU Campus)</p></div>
                        </div>
                    </div>

                    <div class="car-details-box">
                        <div class="car-info">
                            <label>Car Details</label>
                            <p>White Proton (XYZ 1234)</p>
                        </div>
                        <div class="seats-left"><i class='bx bxs-user'></i> 3 Seats Left</div>
                    </div>
                </div>

                <div class="right-col">
                    <div class="note-box">
                        <label>Note</label>
                        <p>Hi, I am going to campus and will pass by LRT Bukit Jalil. Does anyone want to hitch a ride? We'll just split the petrol price. ~RM1 each.</p>
                    </div>

                    <div class="requests-box">
                        <label>Requests</label>
                        <div id="request-list">
                            <div class="request-item">
                                <span class="request-name">Terry Chong</span>
                                <div class="req-actions">
                                    <button class="btn-action btn-reject"><i class='bx bx-x'></i></button>
                                    <button class="btn-action btn-approve"><i class='bx bx-check'></i></button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-actions">
                <button class="btn-cancel" onclick="handleCancel()">Cancel Ride</button>
                <button class="btn-waiting" id="statusBtn">Waiting <i class='bx bxs-chevron-down'></i></button>
            </div>
        </div>
    </div>

    <script>
        const statusBtn = document.getElementById('statusBtn');

        if (statusBtn) {
            statusBtn.addEventListener('click', function() {
                let currentStatus = this.innerText.trim();

                // Step 1: Confirm Completion
                if (currentStatus.includes("Waiting")) {
                    if (confirm("Are you sure you want to mark this ride as completed?")) {
                        this.innerHTML = `Completed <i class='bx bxs-check-circle'></i>`;
                        this.style.background = "#2d3436"; // Black background
                        this.style.color = "white";
                    }
                } 
                // Step 2: Confirm Deletion & Redirect
                else if (currentStatus.includes("Completed")) {
                    if (confirm("This will permanently delete the ride post and take you back to the dashboard. Proceed?")) {
                        deleteRideAndRedirect();
                    }
                }
            });
        }

        function handleCancel() {
            if(confirm("Are you sure you want to cancel this ride? This will remove it from the dashboard.")) {
                deleteRideAndRedirect();
            }
        }

        function deleteRideAndRedirect() {
            // 1. Identify which ride to delete
            const rawIndex = localStorage.getItem('selected_ride_index');
            let rides = JSON.parse(localStorage.getItem('orbit_rides')) || [];
            
            if (rawIndex !== null) {
                const index = parseInt(rawIndex);

                // 2. Remove from the array
                if (index >= 0 && index < rides.length) {
                    rides.splice(index, 1);
                    
                    // 3. Save the new array back to storage
                    localStorage.setItem('orbit_rides', JSON.stringify(rides));
                    
                    // 4. Clean up the pointer
                    localStorage.removeItem('selected_ride_index');
                }
            }

            // 5. Final Step: Always take them back to the dashboard
            window.location.href = 'transportDesktop.php';
        }
    </script>
</body>
</html>