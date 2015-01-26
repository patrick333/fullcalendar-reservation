<?php



class XPOST {
		var $org_url;
		var $post_data;
		var $post_id;
	   function __construct() {
			foreach ($_POST as $k=>$v) {
				$_POST[$k] = rawurldecode($v);
			}	   
			$this->post_data = $_POST;	
			$this->org_url =  $this->post_data['org_url'];
			$this->post_id = $this->post_data['post_id'];
	   }
	   function call($data) {
			header('Location:'.$this->org_url.'node_side.html?CBK=_QALET_.afterPost.'.$this->post_id.'&TM='.json_encode($data));	
	   }	   
	   function getPostData() {
			return  json_decode($this->post_data['node_data'], true);
	   }

	   function getToken(){
	   		return  json_decode($this->post_data['master_cookie'], true);
	   }
	}










?>