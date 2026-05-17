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
    <title>Orbit - Bus Shuttle Services</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="<?php echo STYLES; ?>/transport-global.css">
    <link rel="stylesheet" href="<?php echo STYLES ?>/nav-bar.css" />
    <style>
        body { background-color: #f8f9fa; margin: 0; font-family: 'Inter', sans-serif; }
        
        /* Header & Nav overrides for consistency */
        .header-strip { background: white; padding: 15px 5%; display: flex; align-items: center; border-bottom: 1px solid #eee; }
        .back-btn { background: white; border: 1px solid #ddd; padding: 8px 15px; border-radius: 8px; cursor: pointer; font-size: 1.2rem; margin-right: 20px; }
        
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
    </style>
</head>
<body>
    <div class="header-strip">
        <button class="back-btn" onclick="location.href='<?php echo PAGES ?>/transport/dashboard.php'"><i class='bx bx-chevron-left'></i></button>
        <h2 style="font-weight: 800; margin: 0;">Bus Shuttle Services</h2>
    </div>

    <div class="container" style="max-width: 800px; margin-top: 30px;">
        <!-- Schedule Section -->
        <div id="schedule-container">
        </div>
    </div>

    <script src="<?php echo SERVICES; ?>/bus-service.js"></script>
    <script>displayBus();</script>
</body>
</html>