<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Ride Details (Passenger)</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transportglobal.css">
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
        <h2 style="margin-bottom: 25px; color: #2d3436; font-weight: 900; letter-spacing: -0.5px; text-transform: uppercase;">RIDE DETAILS</h2>

        <div class="main-card">
            <div class="details-grid">
                
                <!-- Left Column -->
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

                <!-- Right Column -->
                <div class="right-col">
                    <div class="note-box">
                        <label>Note</label>
                        <p>Hi, I am going to campus and will pass by LRT Bukit Jalil. Does anyone want to hitch a ride? We'll just split the petrol price. ~RM1 each.</p>
                    </div>

                    <div class="contact-box">
                        <label>Contact</label>
                        <p>+123456789</p>
                        <p>TP000001@mail.apu.edu.my</p>
                    </div>
                </div>

            </div>

            <!-- Action Button -->
            <div class="footer-actions">
                <button class="btn-request" onclick="handleRequest()">Request Ride</button>
            </div>
        </div>
    </div>

    <script>
        function handleRequest() {
            // Visual feedback for the button
            const btn = document.querySelector('.btn-request');
            
            if (confirm("Send ride request to Marcus Chen?")) {
                btn.innerHTML = "Request Sent <i class='bx bxs-check-circle'></i>";
                btn.style.background = "#2ecc71";
                btn.disabled = true;
                
                setTimeout(() => {
                    alert("Your request has been sent! Please wait for the driver to approve.");
                    window.location.href = 'transportDesktop.php';
                }, 1000);
            }
        }
    </script>
</body>
</html>