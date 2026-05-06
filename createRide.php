<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orbit - Create Ride</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="transportglobal.css">
    <style>
        /* Logo styling for SVG */
        .logo svg { height: 35px; width: auto; display: block; }
        
        .form-container { background: white; border-radius: 15px; padding: 30px; box-shadow: 0 10px 40px rgba(0,0,0,0.04); max-width: 600px; margin: 40px auto; }
        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; font-weight: 800; font-size: 0.75rem; color: #b2bec3; text-transform: uppercase; margin-bottom: 8px; }
        .input-field { width: 100%; padding: 12px 15px; border: 2px solid #f1f2f6; border-radius: 10px; font-weight: 700; outline: none; transition: 0.3s; }
        textarea.input-field { resize: none; height: 80px; }
        .row-inputs { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .form-actions { display: flex; gap: 15px; margin-top: 30px; }
        .btn { flex: 1; padding: 15px; border-radius: 10px; font-weight: 900; cursor: pointer; border: none; text-transform: uppercase; font-size: 0.9rem; }
        .btn-cancel { background: #f1f2f6; color: #485460; }
        .btn-confirm { background: #007bff; color: white; }

        /* Notification Badge Styles */
        .nav-item { position: relative; }
        .pending-badge {
            position: absolute; top: -5px; right: 5px; background: #ff4757; color: white;
            font-size: 10px; font-weight: 900; width: 18px; height: 18px; border-radius: 50%;
            display: flex; align-items: center; justify-content: center; border: 2px solid white;
        }
        .hidden { display: none !important; }
    </style>
</head>
<body>

    <header class="navigation-bar">
        <a href="transportDesktop.php" class="logo">
            <!-- Replace the comment below with your actual SVG code -->
            <svg viewBox="0 0 100 40" xmlns="http://www.w3.org/2000/svg">
                <text x="0" y="30" font-family="Arial" font-size="30" font-weight="bold" fill="#007bff">ORBIT</text>
            </svg>
        </a>
        <nav class="nav-links">
            <a href="#" class="nav-item"><i class='bx bx-home-alt'></i><span>Home</span></a>
            <a href="transportDesktop.php" class="nav-item active">
                <i class='bx bx-bus'></i>
                <span>Transport</span>
                <span id="transport-badge" class="pending-badge hidden">0</span>
            </a>
            <a href="#" class="nav-item"><i class='bx bx-map-alt'></i><span>Directory</span></a>
            <a href="#" class="nav-item"><i class='bx bx-calendar'></i><span>Timetable</span></a>
            <a href="#" class="nav-item"><i class='bx bx-dots-vertical-rounded'></i><span>More</span></a>
        </nav>
    </header>

    <div class="container">
        <h1 style="text-align: center; margin-top: 30px;">Post a Ride</h1>
        <div class="form-container">
            <div class="input-group">
                <label>Origin</label>
                <input type="text" id="from" class="input-field" placeholder="e.g. Fortune Park">
            </div>
            <div class="input-group">
                <label>Destination</label>
                <input type="text" id="to" class="input-field" placeholder="e.g. APU Campus">
            </div>
            <div class="row-inputs">
                <div class="input-group">
                    <label>Time</label>
                    <input type="time" id="time" class="input-field">
                </div>
                <div class="input-group">
                    <label>Available Seats (Max 4)</label>
                    <input type="number" id="seats" class="input-field" min="1" max="4" value="1">
                </div>
            </div>
            <div class="input-group">
                <label>Ride Type</label>
                <select id="type" class="input-field type-volunteer" onchange="this.className='input-field ' + (this.value === 'VOLUNTEER' ? 'type-volunteer' : 'type-split')">
                    <option value="VOLUNTEER">Volunteer (Free)</option>
                    <option value="SPLIT FARE">Split Fare</option>
                </select>
            </div>
            <div class="input-group">
                <label>Notes (Optional)</label>
                <textarea id="note" class="input-field" placeholder="e.g. Meet at Block A lobby"></textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-cancel" onclick="history.back()">Cancel</button>
                <button class="btn btn-confirm" onclick="saveRide()">Confirm Post</button>
            </div>
        </div>
    </div>

<script>
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

function saveRide() {
    const from = document.getElementById('from').value;
    const to = document.getElementById('to').value;
    const time = document.getElementById('time').value;
    const seats = parseInt(document.getElementById('seats').value);
    const type = document.getElementById('type').value;
    const note = document.getElementById('note').value;

    if (!from || !to || !time) {
        alert("Please fill in the required fields.");
        return;
    }

    if (seats > 4) {
        alert("Maximum limit is 4 seats.");
        return;
    }

    // Prepare new ride object
    const newRide = {
        id: 'RIDE' + Date.now(),
        from: from,
        to: to,
        time: time,
        seats: seats,
        type: type,
        note: note,
        driverName: "Current User", // In a real app, this would be the logged-in user
        driverID: "TP012345",
        avatar: "https://i.pravatar.cc/150?u=TP012345"
    };

    // Save to localStorage
    const rides = JSON.parse(localStorage.getItem('orbit_rides') || '[]');
    rides.push(newRide);
    localStorage.setItem('orbit_rides', JSON.stringify(rides));

    alert("Ride posted successfully!");
    window.location.href = 'transportDesktop.php';
}

window.onload = updateBadge;
</script>
</body>
</html>