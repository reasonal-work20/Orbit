<?php
require_once $_SERVER['DOCUMENTATION_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/carpool-feature.php';

/**
 * !! IMPORTANT !!
 * Functions Available
 * getAvailable  -> Takes in an associated array and returns the list of available rides.
 *               -> Input Keys [search, role, filter] *Note all three keys must exists (even if empty)
 *               -> Output format [[Refer to output keys for keys], []]
 *               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat]
 * 
 * requester     -> Takes in the carpoolID and returns the details of a carpool ride for the requester pov.
 *               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat, 
 *                              carColour, carPlate, carModel, note, phone, email]
 *
 * host          -> Takes in the carpoolID and returns the details of a carpool ride for the host pov.
 *               -> Output Keys [carpoolID, name, picture, hostID, time, start, destination, seat, 
 *                  carColour, carPlate, carModel, note, requester]
 *               -> Note that requester is a list in the format [[userID, name], [userID, name]]
 * 
 * getActive     -> Output Keys [host, requester, carpoolID] *Note host and requester is True/False indicating their role.
 *
 * newRide       -> Takes in an associated array and returns error string.
 *               -> Input: [userID, type, start, destination, time, carColour, carPlate, carModel, capacity, note]
 *
 * cancelRide    -> Takes in an associated array and returns error string. 
 *               -> Input: [carpoolID]
 *
 * changeStatus  -> Takes in associated array and returns error string.
 *               -> Input: [carpoolID, status]
 *
 * approveRequest -> Takes in associated array and returns error string.
 *                -> Input: [carpoolID, approval]
 *
 * newRequest    -> Takes in associated array and returns error string.
 *               -> Input: [carpoolID, userID]
 *
 * cancelRequest -> Takes in associated array and returns error string.
 *               -> Input: [requestID]
 */
?>