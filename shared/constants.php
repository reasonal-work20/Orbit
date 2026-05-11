<?php
// Ensure session is started to check roles
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

define('ROOT', $_SERVER['DOCUMENT_ROOT']);

/** Constants used in the frontend (client side). */
define('INDEX', '/Orbit/client/index.php');
define('STYLES', '/Orbit/client/src/styles');
define('SHARED', '/Orbit/client/src/shared');
define('ASSETS', '/Orbit/client/src/assets');
define('ICONS', '/Orbit/client/src/assets/icons');
define('APP', '/Orbit/client/src/app/redirect.php?page=');
define('COMPONENTS', '/Orbit/client/src/shared/components');
define('FEATURES', '/Orbit/client/src/features');
define('SERVICES', '/Orbit/client/src/services');
define('UPLOADS', '/Orbit/client/src/uploads');
define('PAGES', '/Orbit/client/src/pages');
define('MODALS', '/Orbit/client/src/shared/modals');
define('NAVIGATION', '/Orbit/client/src/shared/navigation-bar');

/** Constants used in the backend (server side). */
define('CONFIG', '/Orbit/server/config/config.php');
define('CONTROLLERS', '/Orbit/server/controllers');
define('MODELS', '/Orbit/server/models');
define('ROUTES', '/Orbit/server/routes');
define('LOGIC', '/Orbit/server/logic');
define('DATA', '/Orbit/server/data');
define('TESTS', '/Orbit/server/tests');
?>