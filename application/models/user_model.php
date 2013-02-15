<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('id', 'username', 'password', 'email', 'name', 'last_login', 'icon', 'banner', 'confirmed', 'ispremium', 'agent_id', 'package_id', 'msisdn');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, USER);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, USER);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['id'] = $Param['id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		// Sync
		$Result['user_id'] = $Result['id'];
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['username'])) {
			$SelectQuery  = "
				SELECT User.*
				FROM ".USER." User
				WHERE User.username = '".$Param['username']."'
				LIMIT 1
			";
		} else if (isset($Param['user_id'])) {
			$SelectQuery  = "
				SELECT User.*, Company.*
				FROM ".USER." User
				LEFT JOIN ".COMPANY_USER." CompanyUser ON CompanyUser.user_id = User.id
				LEFT JOIN ".COMPANY." Company ON Company.company_id = CompanyUser.company_id
				WHERE User.id = '".$Param['user_id']."'
				LIMIT 1
			";
		}
		
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		if (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array = $this->Sync($Row);
		}
		
		return $Array;
	}
	
	function GetArray($Param = array()) {
		$Array = array();
		$StringCompany = (!empty($Param['company_id'])) ? "AND CompanyUser.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'User.username ASC';
		
		$SelectQuery = "
			SELECT User.*, Company.company_id, Company.company_name
			FROM ".USER." User
			LEFT JOIN ".COMPANY_USER." CompanyUser ON CompanyUser.user_id = User.id
			LEFT JOIN ".COMPANY." Company ON Company.company_id = CompanyUser.company_id
			WHERE 1 $StringCompany $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Row = $this->Sync($Row);
			$Array[] = $Row;
		}
		
		return $Array;
	}
	
	function GetCount($Param = array()) {
		$TotalRecord = 0;
		
		$StringCompany = (!empty($Param['company_id'])) ? "AND CompanyUser.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".USER." User
			LEFT JOIN ".COMPANY_USER." CompanyUser ON CompanyUser.user_id = User.id
			LEFT JOIN ".COMPANY." Company ON Company.company_id = CompanyUser.company_id
			WHERE 1 $StringCompany $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
		if (isset($Param['user_id'])) {
			$DeleteQuery  = "DELETE FROM ".COMPANY_USER." WHERE user_id = '".$Param['user_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
			
			$DeleteQuery  = "DELETE FROM ".USER." WHERE id = '".$Param['user_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
	
	function Sync($Record) {
		$Record = StripArray($Record);
		$Record['user_id'] = $Record['id'];
		
		return $Record;
	}
	
	function LoginRequeired() {
		if (! $this->IsLogin()) {
			header("Location: " . $this->config->item('base_url'));
			exit;
		}
	}
	
	function IsLogin() {
		$Result = false;
		if (isset($_SESSION['UserAdmin']) && is_array($_SESSION['UserAdmin'])) {
			$Result = true;
		}
		
		return $Result;
	}
	
	function GetUser() {
		return $_SESSION['UserAdmin'];
	}
	
	function SetCompany($Param) {
		$_SESSION['UserAdmin'] = $Param;
	}
	
	function GetCompanyID() {
		$UserAdmin = $_SESSION['UserAdmin'];
		$UserAdmin['company_id'] = (isset($UserAdmin['company_id'])) ? $UserAdmin['company_id'] : 0;
		
		return $UserAdmin['company_id'];
	}
}