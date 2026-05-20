<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . SERVICES . '/manage-user-service.php';
require_once ROOT . MODALS . '/modal.php';

// Clean up variables for safety
$user = getUser($_SESSION['userID']);
$name = htmlspecialchars($user['name']);
$email = htmlspecialchars($user['email']);
$picture = $user['picture'] ? UPLOADS . '/' . $user['picture'] : UPLOADS . '/default-profile.png';
$contact = $user['phone'] ? $user['phone'] : 'N/A';
$programme = isset($user['programme']) ? $user['programme'] : 'N/A';
if ($programme != 'N/A') {
    $tag = $user['intakeID'] . "|" . $user['programme'];
} else {
    $tag = $user['role'];
}

$profileHtml = "
<div class='profile-container'>
    <div class='profile-info'>
        <div class='modal-profile-img-container'>
            <img src='{$picture}' class='modal-profile-img' alt='Profile Picture'>
        </div>
        <div class='name-section'>
            <span class='profile-name'>{$name}</span>
            <div class='id-tag'>{$tag}</div>
        </div>
    </div>

    <div class='profile-details'>
        <div class='info-group'>
            <span class='heading2'>Programme</span>
            <p class='programme-text'>{$programme}</p>
        </div>
        
        <div class='info-group'>
            <span class='heading2'>Contacts</span>
            <a href='mailto:{$email}' class='email-link'>{$email}</a>
            <a href='tel:{$contact}' class='contact-link'>{$contact}</a>
        </div>
    </div>
</div>
";
$modalObj = new Modal('userProfileView', 'large');
echo $modalObj->render("My Profile", $profileHtml);
?>