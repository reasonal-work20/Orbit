<?php

$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/src/config/config.php');

$_SESSION['current_page'] = 'home';

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>/src/styles/global.css?version=<?php echo time(); ?>">
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>/src/styles/student.css?version<?php echo time() ?>">
    <link rel="icon" type="image/png" href="<?php echo BASE_URL; ?>/src/resources/icons/orbit-logo-square.svg?version=<?php echo time(); ?>">
    <title>Orbit</title>
</head>

<body>
    <header>
        <?php include_once($doc_root_folder . '/src/components/navigation_bar.php'); ?>
    </header>
</body>

</html>