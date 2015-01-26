<?php


function isNodeLeaf($pid, $SonIds){
	return !isset($SonIds[$pid]);
}

function nodeToArray($pid,$SonIds, $CidToName){
	if(isNodeLeaf($pid, $SonIds)){
		return array("node"=>$pid,
			"id"=>$pid,
			"title"=>$CidToName[$pid]);
	}
	else{
		$length=count($SonIds[$pid]);
		$nodeComposite=array();
		for($i=0;$i<$length-1;$i++){
			$nodeComposite[]=nodeToArray($SonIds[$pid][$i],$SonIds,$CidToName);
		}
		
		return array("node"=>$nodeComposite,
			"id"=>$pid,
			"title"=>$CidToName[$pid]);
	}
}

function nodeToArrayList($pid,$SonIds){
	if(!isNodeLeaf($pid, $SonIds)){
		$length=count($SonIds[$pid]);
		$nodeComposite=[$pid];
		for($i=0;$i<$length-1;$i++){
			$nodeComposite[]=nodeToArrayList($SonIds[$pid][$i], $SonIds);
		}
		return $nodeComposite;
	}
	else 
		return $pid;
}








?>