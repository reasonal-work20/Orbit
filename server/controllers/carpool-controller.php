<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT.CONFIG;
require_once ROOT.MODELS.'/carpool.php';
require_once ROOT.MODELS.'/carpool-request.php';

class CarpoolController {
    private $carpoolEditor;
    private $requestEditor;

    public function __construct() {
        $this->carpoolEditor = new Carpool($connect);
        $this->requestEditor = new CarpoolRequest($connect);
    }

    public function newRide() {}

    public function newRequest() {}

    public function cancelRequest() {}
}
?>