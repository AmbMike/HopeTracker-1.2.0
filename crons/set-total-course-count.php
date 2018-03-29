<?php
/** stet the total number of courses on the course page */
/* Config Root */
require_once('../config/constants.php');

require_once( CLASSES . 'Courses.php' );
$Course = new Courses();

$Course->set_total_courses();