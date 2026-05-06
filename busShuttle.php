<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orbit - Bus Shuttle Services</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transportglobal.css">
    <style>
        body { background-color: #f8f9fa; margin: 0; font-family: 'Inter', sans-serif; }
        
        /* Header & Nav overrides for consistency */
        .header-strip { background: white; padding: 15px 5%; display: flex; align-items: center; border-bottom: 1px solid #eee; }
        .back-btn { background: white; border: 1px solid #ddd; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-size: 1.2rem; margin-right: 20px; }
        
        /* Filter Card */
        .filter-card {
            background: white; border-radius: 12px; padding: 30px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05); margin-bottom: 30px;
        }
        .days-header { display: flex; justify-content: space-around; margin-bottom: 25px; font-weight: 800; color: #2d3436; }
        
        .filter-row { display: flex; align-items: center; gap: 15px; margin-bottom: 20px; padding: 10px; border-radius: 10px; cursor: pointer; position: relative; }
        .filter-row i { font-size: 1.5rem; }
        .filter-row.from i { color: #007bff; }
        .filter-row.to i { color: #eb4d4b; }
        .filter-info { flex-grow: 1; }
        .filter-label { font-size: 0.7rem; color: #b2bec3; font-weight: 800; text-transform: uppercase; }
        .filter-value { font-size: 1rem; font-weight: 700; color: #2d3436; }
        
        .reset-btn {
            width: 100%; padding: 12px; border: 1.5px solid #ddd; background: white;
            border-radius: 8px; font-weight: 800; cursor: pointer; color: #2d3436; margin-top: 10px;
        }

        /* Schedule Card */
        .schedule-card {
            background: white; border-radius: 15px; margin-bottom: 20px; overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
        .schedule-header { padding: 20px; font-weight: 900; text-transform: uppercase; font-size: 0.9rem; }
        .purple-line { border-top: 4px solid #9b59b6; }
        .blue-line { border-top: 4px solid #007bff; }
        
        .time-grid { padding: 25px; display: flex; gap: 15px; flex-wrap: wrap; }
        .time-slot {
            background: #f1f3f5; padding: 15px 30px; border-radius: 10px;
            font-weight: 800; color: #2d3436; font-size: 0.9rem;
        }
        .time-slot.active { background: white; border: 2px solid #2d3436; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        
        .note-text { padding: 0 25px 20px; font-size: 0.65rem; color: #b2bec3; font-weight: 600; }

        /* Dropdown Select Hidden Style */
        .hidden-select { position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer; }
    </style>
</head>
<body>

    <header class="navigation-bar">
        <a href="#" class="logo">ORBIT</a>
        <nav class="nav-links">
            <a href="#" class="nav-item"><i class='bx bx-home-alt'></i><span>Home</span></a>
            <a href="transportDesktop.php" class="nav-item active">
                <i class='bx bx-bus'></i><span>Transport</span>
                <span id="transport-badge" class="pending-badge hidden">0</span>
            </a>
            <a href="#" class="nav-item"><i class='bx bx-map-alt'></i><span>Directory</span></a>
            <a href="#" class="nav-item"><i class='bx bx-calendar'></i><span>Timetable</span></a>
            <a href="#" class="nav-item"><i class='bx bx-dots-vertical-rounded'></i><span>More</span></a>
        </nav>
    </header>

    <div class="header-strip">
        <button class="back-btn" onclick="location.href='transportDesktop.php'"><i class='bx bx-chevron-left'></i></button>
        <h2 style="font-weight: 800; margin: 0;">Bus Shuttle Services</h2>
    </div>

    <div class="container" style="max-width: 800px; margin-top: 30px;">
        
        <!-- Filter Card -->
        <div class="filter-card">
            <div class="days-header">
                <span>Monday - Friday</span>
                <span>Saturday</span>
                <span>Sunday</span>
            </div>

            <div class="filter-row from">
                <i class='bx bxs-map-pin'></i>
                <div class="filter-info">
                    <div class="filter-label">From</div>
                    <div class="filter-value" id="from-val">APU Campus</div>
                </div>
                <i class='bx bx-chevron-down'></i>
                <select class="hidden-select" id="select-from" onchange="updateFilter('from')">
                    <option value="APU Campus">APU Campus</option>
                    <option value="LRT Bukit Jalil">LRT Bukit Jalil</option>
                </select>
            </div>

            <div class="filter-row to">
                <i class='bx bxs-target-lock'></i>
                <div class="filter-info">
                    <div class="filter-label">To</div>
                    <div class="filter-value" id="to-val">LRT Bukit Jalil</div>
                </div>
                <i class='bx bx-chevron-down'></i>
                <select class="hidden-select" id="select-to" onchange="updateFilter('to')">
                    <option value="LRT Bukit Jalil">LRT Bukit Jalil</option>
                    <option value="M Vertica">M Vertica</option>
                    <option value="City of Green">City of Green</option>
                </select>
            </div>

            <button class="reset-btn" onclick="location.reload()">Reset</button>
        </div>

        <!-- Schedule Section -->
        <div id="schedule-container">
            <!-- Purple Card -->
            <div class="schedule-card">
                <div class="schedule-header purple-line" style="color: #9b59b6;">APU CAMPUS → LRT BUKIT JALIL</div>
                <div class="time-grid">
                    <div class="time-slot active">7:45 A.M.</div>
                    <div class="time-slot">8:00 A.M.</div>
                    <div class="time-slot">8:15 A.M.</div>
                </div>
                <div class="note-text">Note: *All times are based on the Malaysian timezone (GMT +8)</div>
            </div>

            <!-- Blue Card -->
            <div class="schedule-card">
                <div class="schedule-header blue-line" style="color: #007bff;">APU CAMPUS → LRT BUKIT JALIL</div>
                <div class="time-grid">
                    <div class="time-slot active">7:45 A.M.</div>
                    <div class="time-slot">8:00 A.M.</div>
                    <div class="time-slot">8:15 A.M.</div>
                </div>
                <div class="note-text">Note: *All times are based on the Malaysian timezone (GMT +8)</div>
            </div>
        </div>
    </div>

    <script>
        function updateFilter(type) {
            const select = document.getElementById('select-' + type);
            document.getElementById(type + '-val').innerText = select.value;
        }

        // Keep the notification bubble updated
        function updateBadge() {
            const myRequests = JSON.parse(localStorage.getItem('user_requests') || '[]');
            const badge = document.getElementById('transport-badge');
            const pendingCount = myRequests.filter(r => r.status === "Pending").length;

            if (pendingCount > 0) {
                badge.innerText = pendingCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        window.onload = updateBadge;
    </script>
</body>
</html>