<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Orbit/shared/constants.php';
require_once ROOT . ROUTES . '/campus-navigation.php';

/**
 * !! IMPORTANT !!
 * Only 2 functions are available. 
 * These 2 functions can handle all of the request needed for the feature.
 * 
 * Function >> getLocation($data)
 * getLocation($data) >> input
 * | mode options => default (returns all)                                  | input ["mode"=>"default"]
 * |              => floor (returns all location on a selected floor)       | input ["mode"=>"floor", "floor"=>"3"]
 * |              => search (returns all location based on search result)   | input ["mode"=>"search", "search"=>"A"]
 * |              => type (returns all location based on type)              | input ["mode"=>"type", "type"=>"Classroom"]
 * 
 * getLocation($data) >> output
 *  This function will return a list of array that looks like this.
 *  [
 *      ["locationID" => "A0401", "name" => "A-04-01", "floor" => "4", "type" => "Classroom"],
 *      ["locationID" => "A0401", "name" => "A-04-01", "floor" => "4", "type" => "Classroom"]
 *  ]
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * 
 * Function >> getMap($condition)
 * getMap($condition) >> input
 * | mode options => default (returns the original map of a selected floor)  | input ["mode"=>"default"]
 * |              => point (returns the map with the point highlighted)      | input ["mode"=>"point", "point"=>"A0403", "floor"=>"4"]
 * |              => route (returns the map with route hightlighted)         | input ["mode"=>"route", "start"=>"A0401", "end"=>"A0402", "type"=>"stair"]
 *                Note: Use the ID of the point only. Type refers to either stair or elevator.
 * 
 * getMap($condition) >> output
 *  This function will return an associated array that looks like this based on the modes.
 * | default | ["svg"=>""]
 * | point   | ["svg"=>""]
 * | route   | ["path"=>["A-04-02", "Walk", "A-04-03], "svg" => ["", ""]]
 * Note that only in route mode, the function will return the svg as a list as there can be multiple maps to show the route when changing floors.
*/
?>