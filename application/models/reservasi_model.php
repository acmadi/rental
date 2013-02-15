<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Reservasi_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('reservasi_id', 'schedule_id', 'reservasi_status_id', 'customer_name', 'customer_address', 'customer_phone', 'reservasi_capacity', 'reservasi_price', 'reservasi_total', 'reservasi_note', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['reservasi_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, RESERVASI);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['reservasi_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, RESERVASI);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['reservasi_id'] = $Param['reservasi_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['reservasi_id'])) {
			$SelectQuery  = "
				SELECT Reservasi.*
				FROM ".RESERVASI." Reservasi
				WHERE Reservasi.reservasi_id = '".$Param['reservasi_id']."'
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
		$StringSearch = (isset($Param['NameLike'])) ? "AND Reservasi.reservasi_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Reservasi.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'reservasi_name ASC';
		
		$SelectQuery = "
			SELECT
				Reservasi.*, ReservasiStatus.reservasi_status_name,
				Schedule.schedule_id, Schedule.schedule_date, Schedule.schedule_depature, Roster.roster_dest
			FROM ".RESERVASI." Reservasi
			LEFT JOIN ".SCHEDULE." Schedule ON Schedule.schedule_id = Reservasi.schedule_id
			LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
			LEFT JOIN ".RESERVASI_STATUS." ReservasiStatus ON ReservasiStatus.reservasi_status_id = Reservasi.reservasi_status_id
			WHERE 1 $StringSearch $StringCompany $StringFilter
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
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Reservasi.reservasi_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Reservasi.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".RESERVASI." Reservasi
			LEFT JOIN ".SCHEDULE." Schedule ON Schedule.schedule_id = Reservasi.schedule_id
			LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
			LEFT JOIN ".RESERVASI_STATUS." ReservasiStatus ON ReservasiStatus.reservasi_status_id = Reservasi.reservasi_status_id
			WHERE 1 $StringSearch $StringCompany $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
		if (isset($Param['reservasi_id'])) {
			$DeleteQuery  = "DELETE FROM ".RESERVASI." WHERE reservasi_id = '".$Param['reservasi_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
	
	function Sync($Record) {
		$Record = StripArray($Record);
		
		return $Record;
	}
}