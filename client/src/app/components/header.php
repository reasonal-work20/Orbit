<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';

// This function automatically creates the head section of the HTML document
// It takes in a title, and an array of CSS file names to include in the head
// Usage: createHead('Page Title', ['style1.css', 'style2.css']);
// You can first define an array as a variable, then pass it directly into the function.
function createHead($title, $cssFiles) {
    echo "<!DOCTYPE html>
    <html lang='en'>
    <head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <link rel='icon' type='image/png' href='" . ASSETS . "/orbit-logo-square.svg'>
    <title>" . $title . "</title>";
    foreach ($cssFiles as $file) {
        echo '<link rel="stylesheet" type="text/css" href="' . STYLES . '/' . $file . '?version=' . time() . '">';
    }
    echo "</head>
    <body>
    <main class='content-container'>";
}

?>