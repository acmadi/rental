<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Driver_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('driver_id', 'driver_name', 'driver_address', 'driver_phone', 'driver_mobile', 'driver_fee', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['driver_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, DRIVER);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['driver_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, DRIVER);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['driver_id'] = $Param['driver_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['driver_id'])) {
			$SelectQuery  = "
				SELECT Driver.*
				FROM ".DRIVER." Driver
				WHERE Driver.driver_id = '".$Param['driver_id']."'
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
		$StringSearch = (isset($Param['NameLike'])) ? "AND Driver.driver_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Driver.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'driver_name ASC';
		
		$SelectQuery = "
			SELECT Driver.*
			FROM ".DRIVER." Driver
			WHERE 1 $StringSearch $StringCompany $StringFilter
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
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Driver.driver_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Driver.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".DRIVER." Driver
			WHERE 1 $StringSearch $StringCompany $StringFilter
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
        if (isset($Param['driver_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".RENTAL_DETAIL." WHERE driver_id = '".$Param['driver_id']."'";
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".SCHEDULE." WHERE driver_id = '".$Param['driver_id']."'";
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
		
		if (isset($Param['driver_id'])) {
			$DeleteQuery  = "DELETE FROM ".DRIVER." WHERE driver_id = '".$Param['driver_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}