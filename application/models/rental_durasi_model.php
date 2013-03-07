<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rental_Durasi_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('rental_durasi_id', 'rental_durasi_name', 'rental_durasi_order');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['rental_durasi_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, RENTAL_DURASI);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['rental_durasi_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, RENTAL_DURASI);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['rental_durasi_id'] = $Param['rental_durasi_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['rental_durasi_id'])) {
			$SelectQuery  = "
				SELECT RentalDurasi.*
				FROM ".RENTAL_DURASI." RentalDurasi
				WHERE RentalDurasi.rental_durasi_id = '".$Param['rental_durasi_id']."'
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
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'rental_durasi_order ASC';
		
		$SelectQuery = "
			SELECT RentalDurasi.*
			FROM ".RENTAL_DURASI." RentalDurasi
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
			FROM ".RENTAL_DURASI." RentalDurasi
			WHERE 1 $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
}