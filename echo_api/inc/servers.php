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
	case 'localdev':
	$dev_mode="localdev";
	break;
	case 'dev':
	$dev_mode="dev";
	break;
	case 'stage':
	$dev_mode="stage";
	break;


}



if ($dev_mode=="localdev") {
		$setting = array(
		'servers'=>array(
			'dev'=>"http://localdev.sainclub.com/",
			'authen'=>"http://localdev.sainclub.com/",
			

			)
		);
}
elseif ($dev_mode=="dev") {
	$setting = array(
		'servers'=>array(
			'dev'=>'http://dev.sainclub.com/',
			'authen'=>'http://dev.sainclub.com/',

			)
		);
}

elseif ($dev_mode=="stage") {
	$setting = array(
		'servers'=>array(
			'dev'=>'http://stage.sainclub.com/',
			'authen'=>'http://stage.sainclub.com/',

			)
		);
}



?>