<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_User_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('company_user_id', 'company_id', 'user_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['company_user_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, COMPANY_USER);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['company_user_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, COMPANY_USER);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['company_user_id'] = $Param['company_user_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function UpdateUser($Param) {
		$this->Delete(array('user_id' => $Param['user_id']));
		$this->Update($Param);
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['company_user_id'])) {
			$SelectQuery  = "
				SELECT CompanyUser.*
				FROM ".COMPANY_USER." CompanyUser
				WHERE CompanyUser.company_user_id = '".$Param['company_user_id']."'
				LIMIT 1
			";
		}
		
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		if (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array = StripArray($Row);
		}
		
		return $Array;
	}
	
	function Delete($Param) {
		if (isset($Param['company_user_id'])) {
			$DeleteQuery  = "DELETE FROM ".COMPANY_USER." WHERE company_user_id = '".$Param['company_user_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
		} else if (isset($Param['user_id'])) {
			$DeleteQuery  = "DELETE FROM ".COMPANY_USER." WHERE user_id = '".$Param['user_id']."'";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}