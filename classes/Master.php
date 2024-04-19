<?php
require_once('../config.php');
Class Master extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	function capture_err(){
		if(!$this->conn->error)
			return false;
		else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
			return json_encode($resp);
			exit;
		}
	}
	function save_departemen(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id'))){
				$v = addslashes(trim($v));
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		$check = $this->conn->query("SELECT * FROM `departemen_list` where `name` = '{$name}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "departemen/Section already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `departemen_list` set {$data} ";
			$save = $this->conn->query($sql);
		}else{
			$sql = "UPDATE `departemen_list` set {$data} where id = '{$id}' ";
			$save = $this->conn->query($sql);
		}
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New departemen successfully saved.");
			else
				$this->settings->set_flashdata('success',"departemen successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_departemen(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `departemen_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"departemen successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);

	}
	function save_item(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','no_item_item'))){
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(isset($_POST['no_item_item'])){
			if(!empty($data)) $data .=",";
				$data .= " `no_item_item`='".addslashes(htmlentities($no_item_item))."' ";
		}
		$check = $this->conn->query("SELECT * from `item_list` where `no_item` = '{$no_item}' ".(!empty($id) ? " and id != {$id} " : "")." ")->num_rows;
		if($this->capture_err())
			return $this->capture_err();
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = "no item already exist.";
			return json_encode($resp);
			exit;
		}
		if(empty($id)){
			$sql = "INSERT INTO `item_list` set {$data} ";
		}else{
			$sql = "UPDATE `item_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status'] = 'success';
			if(empty($id))
				$this->settings->set_flashdata('success',"New item successfully saved.");
			else
				$this->settings->set_flashdata('success',"item successfully updated.");
		}else{
			$resp['status'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	function delete_item(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `item_list` where id = '{$id}'");
		if($del){
			$resp['status'] = 'success';
			$this->settings->set_flashdata('success',"item successfully deleted.");
		}else{
			$resp['status'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}
	function search_items(){
		extract($_POST);
		$qry = $this->conn->query("SELECT * FROM item_list where `no_item` LIKE '%{$q}%'");
		$data = array();
		while($row = $qry->fetch_assoc()){
			$data[] = array("label"=>$row['no_item'],"id"=>$row['id'],"name_item"=>$row['name_item'],"code_item"=>$row['code_item']);
		}
		return json_encode($data);
	}
	function save_reject(){
		extract($_POST);
		$data = "";
		foreach($_POST as $k =>$v){
			if(!in_array($k,array('id','reject_no')) && !is_array($_POST[$k])){
				$v = addslashes(trim($v));
				if(!empty($data)) $data .=",";
				$data .= " `{$k}`='{$v}' ";
			}
		}
		if(!empty($reject_no)){
			$check = $this->conn->query("SELECT * FROM `reject_list` where `reject_no` = '{$reject_no}' ".($id > 0 ? " and id != '{$id}' ":""))->num_rows;
			if($this->capture_err())
				return $this->capture_err();
			if($check > 0){
				$resp['status1'] = 'reject_failed';
				$resp['msg'] = "Reject Number already exist.";
				return json_encode($resp);
				exit;
			}
		}else{
			$reject_no ="";
			while(true){
				$reject_no = "REJECT-".(sprintf("%'.011d", mt_rand(1,99999999999)));
				$check = $this->conn->query("SELECT * FROM `reject_list` where `reject_no` = '{$reject_no}'")->num_rows;
				if($check <= 0)
				break;
			}
		}
		$data .= ", reject_no = '{$reject_no}' ";

		if(empty($id)){
			$sql = "INSERT INTO `reject_list` set {$data} ";
		}else{
			$sql = "UPDATE `reject_list` set {$data} where id = '{$id}' ";
		}
		$save = $this->conn->query($sql);
		if($save){
			$resp['status1'] = 'success';
			$reject_id = empty($id) ? $this->conn->insert_id : $id ;
			$resp['id'] = $reject_id;
			$data = "";
			foreach($item_id as $k =>$v){
				if(!empty($data)) $data .=",";
				$data .= "('{$reject_id}','{$v}','{$type_item[$k]}','{$no_lot[$k]}','{$qty[$k]}','{$factor_mt[$k]}','{$ket[$k]}')";
			}
			if(!empty($data)){
				$this->conn->query("DELETE FROM `order_items` where reject_id = '{$reject_id}'");
				$save = $this->conn->query("INSERT INTO `order_items` (`reject_id`,`item_id`,`type_item`,`no_lot`,`qty`,`factor_mt`,`ket`) VALUES {$data} ");
			}
			if(empty($id))
				$this->settings->set_flashdata('success',"Reject Order successfully saved.");
			else
				$this->settings->set_flashdata('success',"Reject Order successfully updated.");
		}else{
			$resp['status1'] = 'failed';
			$resp['err'] = $this->conn->error."[{$sql}]";
		}
		return json_encode($resp);
	}
	
	function delete_reject(){
		extract($_POST);
		$del = $this->conn->query("DELETE FROM `reject_list` where id = '{$id}'");
		if($del){
			$resp['status1'] = 'success';
			$this->settings->set_flashdata('success',"Reject Card successfully deletedMaster.");
		}else{
			$resp['status1'] = 'failed';
			$resp['error'] = $this->conn->error;
		}
		return json_encode($resp);
	}

	function delete_img(){
		extract($_POST);
		if(is_file($path)){
			if(unlink($path)){
				$resp['status1'] = 'success';
			}else{
				$resp['status1'] = 'failed';
				$resp['error'] = 'failed to delete '.$path;
			}
		}else{
			$resp['status1'] = 'failed';
			$resp['error'] = 'Unkown '.$path.' path';
		}
		return json_encode($resp);
	}
}

$Master = new Master();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
$sysset = new SystemSettings();
switch ($action) {
	case 'save_departemen':
		echo $Master->save_departemen();
	break;
	case 'delete_departemen':
		echo $Master->delete_departemen();
	break;
	case 'save_item':
		echo $Master->save_item();
	break;
	case 'delete_item':
		echo $Master->delete_item();
	break;
	case 'search_items':
		echo $Master->search_items();
	break;
	case 'save_reject':
		echo $Master->save_reject();
	break;
	case 'delete_reject':
		echo $Master->delete_reject();
	break;
	
	default:
		// echo $sysset->index();
		break;
}