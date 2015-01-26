<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__).'/../events/events.php');
require_once(dirname(__FILE__).'/../inc/dbcfg.inc.php');

$uid=1;
$start="9";
$date="2015-1-28";
$fetch = new Fetch_data($db_cfg);
$result=$fetch->reserve_event($uid, $start, $date);
echo $result;



?>