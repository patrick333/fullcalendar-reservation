<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(php_sapi_name()=='cli'){
	$host =dirname(__FILE__);
	$result=preg_match('#/(U_.+)/#U',$host,$matches);
	$servername_piece=str_replace(array('U','_'), array('u',''), $matches[1],$count);
}
else{
	$host = @$_SERVER['SERVER_NAME'];
	$servername_pieces=explode(".",$host);
	$servername_piece=$servername_pieces[0];
}


switch ($servername_piece) {
	case 'peihui':
	$db_cfg=array(
		'dbname'=>'echo-driving',
		'host'=>'localhost',
		'user'=>'echo-driving',
		'pass'=>'dianhua'
		);
	break;
	default:
	$db_cfg=array(
		'dbname'=>'echo-driving',
		'host'=>'localhost',
		'user'=>'echo-driving',
		'pass'=>'dianhua'
		);
	break;


}


?>