<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__).'/../../echo_api/events/events.php');
require_once(dirname(__FILE__).'/../../echo_api/inc/dbcfg.inc.php');
require_once(dirname(__FILE__).'/../../echo_api/lib/xpost.php');

$fetch = new Fetch_data($db_cfg);
$result=$fetch->fetch_events();
echo isset($_GET['callback'])?$_GET['callback'].'('.$result.')':$result;
?>