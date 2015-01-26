<?php
class DB {
	var $db_host;
	var $db_user;
	var $db_pass;
	var $db_name;
	var $tbl_cat;
	var $key_names;
	var $do_init = 0;
	var $connected = 0;
	var $db_selected;
	var $affected;
	
	var $dbexist;
	
	var $mem=false;
	var $cid=false;
		//database connection
	var $link;

		//if a function returns FAILED, message will be stored here
	var $db_error;
		//internal result ID
	var $db_result;	
		//constructor
	function DB($db_cfg, $charset='utf8mb4',$memcache=false, $cid=false) {
		if ($db_cfg) {
			$this->db_name = $db_cfg["dbname"];
			$this->db_host = $db_cfg["host"];
			$this->db_user = $db_cfg["user"];
			$this->db_pass = $db_cfg["pass"];
		}
		
		$this->init(); 
			// mysql_query("SET character_set_connection=utf8, character_set_results=utf8, character_set_client=binary");
			// mysql_query("SET character_set_connection=utf8, character_set_results=utf8,character_set_client=utf8");
		
		// mysql_query("SET NAMES latin1");  //数据库和连接字符集都使用latin1时虽然大部分情况下都可以解决乱码问题，
		//但缺点是无法以字符为单位来进行SQL操作，一般情况下将数据库和连接字符集都置为utf8是较好的选择；
		
			// mysql_query("SET NAMES gbk");//not working
			mysql_query("SET NAMES ".$charset);   //works well on node, master. not on your local.
		
			// mysql_query("SET sql_mode=''");  //The default SQL mode is empty (no modes set).

		if (!$this->connected) return false;
	}

	function init() {
		$this->connected = 1;
		$this->link = @mysql_connect($this->db_host, $this->db_user, $this->db_pass, true) or  $this->connected = false;
		$this->set_database();
	}

	//mysql_close is not necessary: The link to the server will be closed as soon as the execution of the script ends, unless it's closed earlier by explicitly calling mysql_close().
	function disconnect() {
		if ($this->link) {
			@mysql_close($this->link);
			$this->connected = 0;
		}
	}		
	
	function set_database($new_db = '') {
		if($new_db) {$this->db_name = $new_db;}		
		if($this->connected) { $db_selected = @mysql_select_db($this->db_name, $this->link); }
		if (!isset($db_selected) || !$db_selected) {
			$this->dbexist=false;
			@trigger_error ($db_error = 'Can\'t use slelected database : ' . @mysql_error());
		} else {
			$this->dbexist = true;
		}
	}

	function safestr($s){
		return mysql_escape_string($s);
	}

	function safearr($a){
		for($i=0; $i<count($a); $i++){
			$a[$i] = mysql_escape_string($a[$i]);
		}
		return $a;
	}
	function list_fields($tbl_name){
		$fields = mysql_list_fields($this->db_name,$tbl_name);
		$columns = mysql_num_fields($fields);
		$res = array();
		for($i = 0; $i<$columns; $i++){
			$res[] = mysql_field_name($fields,$i);
		}
		return $res;
	}	
	function list_fields_array($tbl_name){
		$res=$this->select_all("DESCRIBE ".$tbl_name);
		return $res;
	}
	
	function delete_query($sql) {
		$this->log_query($sql);
		$result = (@mysql_query($sql,$this->link) or $this->set_error("Could not execute query: $sql: ".@mysql_error($this->link)));
		$this->affected = mysql_affected_rows();
		return $result;
	}		

	function mesc_query($sql) {
		$this->log_query($sql);
		$result = (@mysql_query($sql,$this->link) or $this->set_error("Could not execute query: $sql: ".@mysql_error($this->link)));
	}
	
	function update_query($sql) {
		$this->log_query($sql);
		$result = (@mysql_query($sql,$this->link) or $this->set_error("Could not execute query: $sql: ".@mysql_error($this->link)));
		$this->affected = mysql_affected_rows();
		return $result;
	}
	
	function insert_query($sql){
		$this->log_query($sql);
		$result = @mysql_query($sql,$this->link) or $this->set_error("Could not execute query: $sql: ".@mysql_error($this->link));
		if($result){
			$this->affected = mysql_affected_rows();	
			return mysql_insert_id($this->link);
		} else {
				return false;  //check late
			}
		}

		function select_query($sql) {
			$this->log_query($sql);
			$result = $this->send_query($sql);
			
			if(!($result)) {return false;}
			else return mysql_fetch_array($result, MYSQL_ASSOC);
		}
		
		function select_list($sql) {
			$this->log_query($sql);
			$output = array();
			$result = $this->send_query($sql);
			if(!($result)) {return false;}
			else {
				while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
					$output[] = $row;  
				}
			}
			return $output;
		}
		function send_query($sql) {
			$result = @mysql_query($sql,$this->link) or $this->set_error("Could not execute query: $sql: ".@mysql_error($this->link));
			return $result;
		}		
		function log_query($sql) {
			// echo "the query is: ".$sql."<br/>";
		}
		function set_error($sql) {
			//
		} 
	}
