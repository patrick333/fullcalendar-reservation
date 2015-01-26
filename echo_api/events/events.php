<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__FILE__).'/../inc/class.db.inc.php');

class Fetch_data {
	var $db;

	function __construct($db_cfg){
		$this->db=new DB($db_cfg);
	}


	function fetch_events() {
		$tb_event="ed_event";

		$query= "SELECT * FROM $tb_event";
		$events = $this->db->select_list($query);
		if(!$events){
			return json_encode(array('status'=>'FAIL','error'=>"no records selected on $tb_event",'query'=>$query));
		}
		
		return json_encode(array('status'=>'SUCCESS','events'=>$events), 
			JSON_UNESCAPED_UNICODE);
	}	

	function reserve_event($uid,$start,$date) {
		$tb_event="ed_event";
		$time=date ("Y-m-d H:i:s", time());

		$title="Session reserved";
		// $startTStemp= strtotime($date.' '.$start.':00:00');
		// $endTStemp=   strtotime($date.' '.($start+1).':00:00');
		// $start=date("Y-n-j G",$startTStemp);
		// $end=date("Y-n-j G",$endTStemp);

		$startStr=$date.' '.$start.':00:00';
		$endStr=$date.' '.($start+1).':00:00';

		$query="insert into $tb_event (uid,title,start,end,time) values ('$uid','$title','$startStr','$endStr','$time')";
		$newEventId=$this->db->insert_query($query);
		if(!$newEventId){
			return json_encode(array('status'=>'FAIL','error'=>"insert into $tb_event failed.",'query'=>$query));
		}

		$query= "SELECT * FROM $tb_event WHERE eid='$newEventId'";
		$newEvent = $this->db->select_query($query);
		if(!$newEvent){
			return json_encode(array('status'=>'FAIL','error'=>"no records selected on $tb_event",'query'=>$query));
		}
		
		return json_encode(array('status'=>'SUCCESS','newEvent'=>$newEvent), JSON_UNESCAPED_UNICODE);
	}


	function modify_event($uid,$start,$date, $modifyEid) {
		$tb_event="ed_event";
		$time=date ("Y-m-d H:i:s", time());

		$title="Session rescheduled";
		$startStr=$date.' '.$start.':00:00';
		$endStr=$date.' '.($start+1).':00:00';

		$query="update $tb_event set title='$title', start='$startStr', end='$endStr', time='$time' where eid='$modifyEid'";
		$result_update=$this->db->update_query($query);
		if(!$result_update){
			return json_encode(array('status'=>'FAIL','error'=>"UPDATE $tb_event failed.",'query'=>$query));
		}

		$query= "SELECT * FROM $tb_event WHERE eid='$modifyEid'";
		$newEvent = $this->db->select_query($query);
		if(!$newEvent){
			return json_encode(array('status'=>'FAIL','error'=>"no records selected on $tb_event",'query'=>$query));
		}
		
		return json_encode(array('status'=>'SUCCESS','newEvent'=>$newEvent), JSON_UNESCAPED_UNICODE);
	}

}


?>