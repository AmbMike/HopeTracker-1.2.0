<?php
$Page = new \Page_Attr\Page();
$Page->header(array(
    'Title' => "Template v1",
    'Description' => ' ',
    'Show Header' => 'No',
));
$no_footer = true;

/* Action navigation */
include_once($_SERVER['DOCUMENT_ROOT'] . "/hopetracker/site/cwd/template-v1/index.php");