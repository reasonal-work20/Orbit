<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Usage: If true, include footer for index
// If false, include default footer for every page. (No text)
function createFooter($boolean) {
    if ($boolean) {
        include_once ROOT.COMPONENTS . "/index-footer.php";
    } else {
        echo "
            </main>
</body>
</html>
        ";
    }
}