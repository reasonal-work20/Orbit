<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/bus-route.php';

/**
 * Functions available for use to get the bus shuttle schedule.
 * getAll($type), getFew($type, $number)
 * 
 * getAll   -> Takes in a string input used to search through the bus route. 
 *          -> Use "All" to get all the bus route and scheduled bus time.
 *          -> Returns a list of data with all the scheduled bus time.
 * 
 * getFew   -> Takes in a string input used to search through the bus route and integer number to indicate how many scheduled bus time to return.
 *          -> Use "All" to get all the bus route and few scheduled bus time.
 *          -> Returns a list fo data with the scheduled bus time.
 * 
 * !! IMPORTANT !! 
 * Format of the bus route is "LRT-BUKIT JALIL >> APU", refer to APU shuttle bus in APSpace for the location name.
 */
?>