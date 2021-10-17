<?php
// for includes
define("DIR_BASE", __DIR__."/");
define("DIR_CSS", DIR_BASE."css/");
define("DIR_SRC", DIR_BASE."src/");
define("DIR_WEB", DIR_BASE."web/");
define("DIR_LOC", DIR_BASE."local/");
define("DIR_TST", DIR_BASE."test/");
define("DIR_ADM", DIR_BASE."admin/");

// for links
$url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
$subdir = "/~jday/MSIS-2630/A-Recipe-Website";
define("LINK_BASE", $url.$subdir."/");
define("LINK_CSS", LINK_BASE."css/");
define("LINK_SRC", LINK_BASE."src/");
define("LINK_WEB", LINK_BASE."web/");
define("LINK_LOC", LINK_BASE."local/");
define("LINK_TST", LINK_BASE."test/");
define("LINK_ADM", LINK_BASE."admin/");

// for display
define("LEGAL_MSG", "The content of these web pages is not generated by and does not represent the views of Santa Clara University or any of its departments or organizations.");
define("TITLE", "A Recipe Website");
?>