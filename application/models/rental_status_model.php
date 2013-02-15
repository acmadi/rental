<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rental_Status_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('rental_status_id', 'rental_status_name');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['rental_status_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, RENTAL_STATUS);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['rental_status_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, RENTAL_STATUS);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['rental_status_id'] = $Param['rental_status_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['rental_status_id'])) {
			$SelectQuery  = "
				SELECT RentalStatus.*
				FROM ".RENTAL_STATUS." RentalStatus
				WHERE RentalStatus.rental_status_id = '".$Param['rental_status_id']."'
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
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'rental_status_name ASC';
		
		$SelectQuery = "
			SELECT RentalStatus.*
			FROM ".RENTAL_STATUS." RentalStatus
			WHERE 1 $StringFilter
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
		
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".RENTAL_STATUS." RentalStatus
			WHERE 1 $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
		if (isset($Param['rental_status_id'])) {
			$DeleteQuery  = "DELETE FROM ".RENTAL_STATUS." WHERE rental_status_id = '".$Param['rental_status_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}