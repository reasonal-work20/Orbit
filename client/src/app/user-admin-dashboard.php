<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

include_once ROOT . COMPONENTS . '/header.php';
include_once ROOT . COMPONENTS . '/footer.php';

$cssFiles = ["admin-dashboard.css"];

createHead("Orbit | Admin Dashboard", $cssFiles);
?>



<?php
createFooter(false);
?>