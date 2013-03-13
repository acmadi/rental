<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Sms_Log_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('sms_log_id', 'content');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['sms_log_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, SMS_LOG);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['sms_log_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, SMS_LOG);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['sms_log_id'] = $Param['sms_log_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
}