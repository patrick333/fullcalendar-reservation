<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__).'/../../echo_api/events/events.php');
require_once(dirname(__FILE__).'/../../echo_api/inc/dbcfg.inc.php');
require_once(dirname(__FILE__).'/../../echo_api/lib/xpost.php');

$uid=isset($_GET['uid'])?$_GET['uid']:0;
$start=isset($_GET['start'])?$_GET['start']:'0';
$date=isset($_GET['date'])?$_GET['date']:'0';
$modifyMode=isset($_GET['modifyMode'])?$_GET['modifyMode']:'error';
$modifyEid=isset($_GET['modifyEid'])?$_GET['modifyEid']:'error';

$fetch = new Fetch_data($db_cfg);
if($modifyMode=='true'){
	$result=$fetch->modify_event($uid, $start, $date, $modifyEid);
}
else if($modifyMode=='false'){
	$result=$fetch->reserve_event($uid, $start, $date);
}

echo isset($_GET['callback'])?$_GET['callback'].'('.$result.')':$result;
?>