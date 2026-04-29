<?php
$route = curl_init(ROOT.ROUTES.'/login.php');
curl_setopt($route, CURLOPT_POST, true);
curl_setopt($route, CURLOPT_POSTFIELDS, $_POST);
curl_setopt($route, CURLOPT_RETURNTRANSFER, true);
$response = curl_exec($route);
curl_close($route);

$result = json_decode($response, true);
?>