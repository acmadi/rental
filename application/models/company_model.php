<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Company_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('company_id', 'company_name', 'company_address', 'company_phone', 'indocrm_client_id', 'indocrm_privatekey');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['company_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, COMPANY);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['company_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, COMPANY);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['company_id'] = $Param['company_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['company_id'])) {
			$SelectQuery  = "
				SELECT Company.*
				FROM ".COMPANY." Company
				WHERE Company.company_id = '".$Param['company_id']."'
				LIMIT 1
			";
		}
		
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		if (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array = StripArray($Row);
		}
		
		return $Array;
	}
	
	function GetArray($Param = array()) {
		$Array = array();
		$StringSearch = (isset($Param['NameLike'])) ? "AND Company.company_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'company_name ASC';
		
		$SelectQuery = "
			SELECT Company.*
			FROM ".COMPANY." Company
			WHERE 1 $StringSearch $StringFilter
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
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Company.company_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".COMPANY." Company
			WHERE 1 $StringSearch $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
        $RecordCount = 0;
        $SelectQuery = array();
        if (isset($Param['company_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".COMPANY_USER." WHERE company_id = '".$Param['company_id']."'";
        }
        foreach ($SelectQuery as $Query) {
            $SelectResult = mysql_query($Query) or die(mysql_error());
            if (false !== $Row = mysql_fetch_assoc($SelectResult)) {
                $RecordCount += $Row['RecordCount'];
            }
        }
		if ($RecordCount > 0) {
            $Result['QueryStatus'] = '0';
            $Result['Message'] = 'Data tidak bisa dihapus karena data telah terpakai.';
			return $Result;
		}
		
		if (isset($Param['company_id'])) {
			$DeleteQuery  = "DELETE FROM ".COMPANY." WHERE company_id = '".$Param['company_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}