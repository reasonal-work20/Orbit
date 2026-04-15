<?php
$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/src/config/config.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo ASSETS_PATH; ?>/styles/global.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo ASSETS_PATH; ?>/styles/student.css?version<?php echo time() ?>">
    <link rel="icon" type="image/png" href="<?php echo ASSETS_PATH; ?>/icons/orbit-logo-square.svg?version=<?php echo time(); ?>">
    <title>Orbit</title>
</head>

<body>
    <header>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . VIEWS_PATH . '/components/navigation_bar.php'); ?>
    </header>
</body>

</html>