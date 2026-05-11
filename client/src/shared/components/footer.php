<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// Usage: If true, include footer for index
// If false, include default footer for every page. (No text)
function createFooter(bool $boolean) {
    $footer = "";
    if ($boolean) {
        $iconPath = ASSETS . '/icons/apspace-logo.svg';
        $footer = "
        <footer>
            <p class='footer-text'>an extension of</p>
            <img id='apspace-logo' src='$iconPath' alt='apspace logo' aria-hidden='true'>
            <p class='footer-text'>ORBIT &copy; 2026</p>
        </footer>";
    }
    $loadingOverlay = COMPONENTS . '/loading-overlay.js';
    $modalScript = MODALS . '/modal-script.js';
    echo "<script src='$loadingOverlay'></script>
    </main>$footer</body>
    <script src='$modalScript'></script>
    </html>";
}