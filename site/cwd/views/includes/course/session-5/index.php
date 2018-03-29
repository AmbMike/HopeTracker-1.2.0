<?php


/** Get the file names for the current folder/session */
$directory = realpath(dirname(__FILE__));
$scanned_directory = array_diff(scandir($directory), array('..', '.','index.php','variables.php'));

foreach ($scanned_directory as $value):
	echo '<div class="content-item">';
	include_once($directory . '/' . $value);
	echo '</div>';
endforeach;