<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Roster_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->ArrayDay = $this->Day_model->GetArray(array('IsHash' => 1));
		$this->Field = array('roster_id', 'roster_day', 'roster_time', 'roster_dest', 'roster_capacity', 'roster_price', 'roster_active', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['roster_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, ROSTER);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['roster_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, ROSTER);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['roster_id'] = $Param['roster_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['roster_id'])) {
			$SelectQuery  = "
				SELECT Roster.*
				FROM ".ROSTER." Roster
				WHERE Roster.roster_id = '".$Param['roster_id']."'
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
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Roster.roster_dest LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Roster.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'roster_dest ASC';
		
		$SelectQuery = "
			SELECT Roster.*
			FROM ".ROSTER." Roster
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
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Roster.roster_dest LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Roster.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".ROSTER." Roster
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
        if (isset($Param['roster_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".SCHEDULE." WHERE roster_id = '".$Param['roster_id']."'";
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
		
		if (isset($Param['roster_id'])) {
			$DeleteQuery  = "DELETE FROM ".ROSTER." WHERE roster_id = '".$Param['roster_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
	
	function Sync($Record) {
		$Result = StripArray($Record);
		
		// Set Day
		if (isset($Result['roster_day'])) {
			$Result['roster_day_title'] = '';
			$ArrayTemp = explode(',', $Result['roster_day']);
			foreach ($ArrayTemp as $Value) {
				if (!empty($Value)) {
					$Result['roster_day_title'] .= (empty($Result['roster_day_title'])) ? $this->ArrayDay[$Value] : ', ' . $this->ArrayDay[$Value];
				}
			}
		}
		
		return $Result;
	}
}