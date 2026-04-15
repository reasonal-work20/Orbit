<?php
namespace user_controller;

$doc_root_folder = $_SERVER['DOCUMENT_ROOT'] . '/Orbit';
include_once($doc_root_folder . '/config/config.php');

/** User controller is used for routing to the common pages shared by all user roles.
 * This includes, campus navigation, transport, profile and settings.
*/
class user_controller {
    public function login() {
        header("Location: " . VIEWS_PATH . '/login/login_page.php');
    }
}
?>