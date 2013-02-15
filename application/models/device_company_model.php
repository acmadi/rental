<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device_Company_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('device_company_id', 'device_id', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['device_company_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, DEVICE_COMPANY);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['device_company_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, DEVICE_COMPANY);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['device_company_id'] = $Param['device_company_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function UpdateDevice($Param) {
		$this->Delete(array('device_id' => $Param['device_id']));
		$this->Update($Param);
	}
	
	function Delete($Param) {
		if (isset($Param['device_id'])) {
			$DeleteQuery  = "DELETE FROM ".DEVICE_COMPANY." WHERE device_id = '".$Param['device_id']."'";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}