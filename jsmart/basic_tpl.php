<?php
	$lang='';
	if (isset($_GET['lang'])&&$_GET['lang']=='en') 
		$lang='en';
	else $lang='cn';

	$dir='tpl/'.$lang.'/';

	$cfg=array(
		'newEvent_tpl'=>'newEvent.tpl.html',
		'modifyEvent_tpl'=>'modifyEvent.tpl.html',
	);
	echo 'if (!_ED_) var _ED_={TPL:{}};';
	foreach ($cfg as $k=>$v) {
		$filename=$dir.$v;
		
		if (file_exists($filename)) {
			$handle = @fopen($filename, "rb");
			$contents = '';
			while (!feof($handle)) {
				$line=fgets($handle, 4096);
				$line= str_replace("\n", '', $line);
				$line= str_replace("\r", '', $line);
				$contents .= $line;
			}
			fclose($handle);
			$contents=addslashes($contents);
			echo '_ED_.TPL["'.$k.'"]= unescape("'.$contents.'");';		
		}
	}

?>		
