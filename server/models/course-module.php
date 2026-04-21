<?php
/**
* Class model for Course Module.
*/

public class CourseModule() {
    private $connection;

    public function __construct($connection) {
        $this->$connection = $connection;
    }

    public function createCourseModule($intakeID, $moduleID, $lecturerID, $startDate, $endDate) {
        echo "Temp";
    }
}
?>