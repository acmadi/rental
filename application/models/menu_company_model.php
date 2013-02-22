<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Company_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('menu_company_id', 'company_id', 'menu_item_id', 'menu_company_active');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['menu_company_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, MENU_COMPANY);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['menu_company_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, MENU_COMPANY);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['menu_company_id'] = $Param['menu_company_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['menu_company_id'])) {
			$SelectQuery  = "
				SELECT MenuCompany.*
				FROM ".MENU_COMPANY." MenuCompany
				WHERE MenuCompany.menu_company_id = '".$Param['menu_company_id']."'
				LIMIT 1
			";
		} else if (isset($Param['company_id']) && isset($Param['menu_item_id'])) {
			$SelectQuery  = "
				SELECT MenuCompany.*
				FROM ".MENU_COMPANY." MenuCompany
				WHERE MenuCompany.company_id = '".$Param['company_id']."'
					AND MenuCompany.menu_item_id = '".$Param['menu_item_id']."'
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
		if (isset($Param['menu_company_id'])) {
			$DeleteQuery  = "DELETE FROM ".MENU_COMPANY." WHERE menu_company_id = '".$Param['menu_company_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}