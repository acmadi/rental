<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Config_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('config_id', 'company_id', 'config_name', 'config_content', 'hidden');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['config_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, CONFIG, array('AllowSymbol' => 0));
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['config_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, CONFIG, array('AllowSymbol' => 0));
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['config_id'] = $Param['config_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['config_id'])) {
			$SelectQuery  = "
				SELECT Config.*
				FROM ".CONFIG." Config
				WHERE config_id = '".$Param['config_id']."'
				LIMIT 1";
		} else if (isset($Param['config_name']) && isset($Param['company_id'])) {
			$SelectQuery  = "
				SELECT Config.*
				FROM ".CONFIG." Config
				WHERE
					config_name = '".$Param['config_name']."'
					AND company_id = '".$Param['company_id']."'
				LIMIT 1
			";
		} else if (isset($Param['config_name'])) {
			$SelectQuery  = "
				SELECT Config.*
				FROM ".CONFIG." Config
				WHERE config_name = '".$Param['config_name']."'
				LIMIT 1";
		}
		
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		if (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array = StripArray($Row);
		}
		
		return $Array;
	}
	
	function GetArray($Param = array()) {
		$Array = array();
		$StringSearch = (isset($Param['NameLike'])) ? "AND config_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompanyID = (isset($Param['company_id'])) ? "AND company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param, array('gereja' => 'Gereja.nama'));
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'config_name ASC';
		
		$SelectQuery = "
			SELECT Config.*
			FROM ".CONFIG." Config
			WHERE 1 $StringSearch $StringCompanyID $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Row = StripArray($Row);
			$Array[] = $Row;
		}
		
		return $Array;
	}
	
	function GetCount($Param = array()) {
		$TotalRecord = 0;
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND config_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompanyID = (isset($Param['company_id'])) ? "AND company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param, array('gereja' => 'Gereja.nama'));
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".CONFIG." Config
			WHERE 1 $StringSearch $StringCompanyID $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
		if (isset($Param['config_id'])) {
			$DeleteQuery  = "DELETE FROM ".CONFIG." WHERE config_id = '".$Param['config_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
		}
        
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data has been deleted.';
		
		return $Result;
	}
}