<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . NAVIGATION . '/nav-bar.php';

$_SESSION['currentPage'] = 'transport';
renderNavBar();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Orbit | Create Ride</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo STYLES; ?>/transport-global.css">
    <link rel="stylesheet" href="<?php echo STYLES; ?>/nav-bar.css">
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
    <div class="container">
        <h1 style="text-align: center; margin-top: 30px;">Post a Ride</h1>
        <form class="form-container" action="<?php echo SERVICES; ?>/carpool-service.php" method="post">
            <div class="input-group">
                <label>Origin</label>
                <input type="text" id="from" name="start" class="input-field" placeholder="e.g. Fortune Park" required>
            </div>
            <div class="input-group">
                <label>Destination</label>
                <input type="text" id="to" name="destination" class="input-field" placeholder="e.g. APU Campus" required>
            </div>
            <div class="row-inputs">
                <div class="input-group">
                    <label>Time</label>
                    <input type="time" id="time" name="time" class="input-field" required>
                </div>
                <div class="input-group">
                    <label>Available Seats (Max 4)</label>
                    <input type="number" id="seats" name="capacity" class="input-field" min="1" max="4" value="1" required>
                </div>
            </div>
            <div class="input-group">
                <label>Ride Type</label>
                <select id="type" name="type" class="input-field type-volunteer" onchange="this.className='input-field ' + (this.value === 'VOLUNTEER' ? 'type-volunteer' : 'type-split')" required>
                    <option value="VOLUNTEER">Volunteer (Free)</option>
                    <option value="SPLIT FARE">Split Fare</option>
                </select>
            </div>
            <div class="row-inputs">
                <div class="input-group">
                    <label>Car Model</label>
                    <input type="text" name="carModel" id="model" class="input-field" placeholder="Car Model">
                </div>
                <div class="input-group">
                    <label>Car Colour</label>
                    <input type="text" name="carColour" id="colour" class="input-field" placeholder="Car Colour">
                </div>
                <div class="input-group">
                    <label>Car Plate</label>
                    <input type="text" name="carPlate" id="plate" class="input-field" placeholder="License Plate">
                </div>
            </div>
            <div class="input-group">
                <label>Notes (Optional)</label>
                <textarea id="note" name="note" class="input-field" placeholder="e.g. Meet at Block A lobby"></textarea>
            </div>
            <div class="form-actions">
                <button class="btn btn-cancel" onclick="window.location.href='<?php echo PAGES ?>/transport/carpool-manage.php'" type="button">Cancel</button>
                <button class="btn btn-confirm" name="newRide" type="submit">Confirm Post</button>
            </div>
        </form>
    </div>

</body>
</html>