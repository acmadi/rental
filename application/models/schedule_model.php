<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->ArrayDay = $this->Day_model->GetArray(array('IsHash' => 1));
		$this->Field = array('schedule_id', 'roster_id', 'car_id', 'driver_id', 'schedule_date', 'schedule_depature', 'schedule_arrival', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['schedule_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, SCHEDULE);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['schedule_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, SCHEDULE);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['schedule_id'] = $Param['schedule_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['schedule_id'])) {
			$SelectQuery  = "
				SELECT Schedule.*, Roster.roster_dest, Roster.roster_price, Driver.driver_name, Company.company_name, Company.company_address
				FROM ".SCHEDULE." Schedule
				LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
				LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = Schedule.driver_id
				LEFT JOIN ".COMPANY." Company ON Company.company_id = Schedule.company_id
				WHERE Schedule.schedule_id = '".$Param['schedule_id']."'
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
		$StringCompany = (!empty($Param['company_id'])) ? "AND Schedule.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringCustom = (!empty($Param['StringCustom'])) ? $Param['StringCustom']  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'schedule_date ASC';
		
		$SelectQuery = "
			SELECT Schedule.*, Roster.roster_dest, Roster.roster_price, Device.device, Driver.driver_name
			FROM ".SCHEDULE." Schedule
			LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
			LEFT JOIN ".DEVICE." Device ON Device.id = Schedule.car_id
			LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = Schedule.driver_id
			WHERE 1 $StringCompany $StringCustom $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array[] = $this->Sync($Row);
		}
		
		return $Array;
	}
	
	function GetCount($Param = array()) {
		$TotalRecord = 0;
		
		$StringCompany = (!empty($Param['company_id'])) ? "AND Schedule.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringCustom = (!empty($Param['StringCustom'])) ? $Param['StringCustom']  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".SCHEDULE." Schedule
			LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
			LEFT JOIN ".DEVICE." Device ON Device.id = Schedule.car_id
			LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = Schedule.driver_id
			WHERE 1 $StringCompany $StringCustom $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function GetSummary($Param = array()) {
		$Array = array();
		$StringCompany = (!empty($Param['company_id'])) ? "AND Schedule.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'schedule_date ASC';
		
		$SelectQuery = "
			SELECT Schedule.schedule_date, Roster.roster_dest, Driver.driver_name, SUM(reservasi_total) total
			FROM ".SCHEDULE." Schedule
			LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
			LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = Schedule.driver_id
			LEFT JOIN ".RESERVASI." Reservasi ON Reservasi.schedule_id = Schedule.schedule_id
			WHERE 1 $StringCompany $StringFilter
			GROUP BY Schedule.schedule_date, Roster.roster_dest, Driver.driver_name
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array[] = $this->Sync($Row);
		}
		
		return $Array;
	}
	
	function GetDetail($Param = array()) {
		$Array = array();
		$StringCompany = (!empty($Param['company_id'])) ? "AND Schedule.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'schedule_date ASC';
		
		$SelectQuery = "
			SELECT Schedule.schedule_date, Roster.roster_dest, Driver.driver_name, reservasi_total
			FROM ".SCHEDULE." Schedule
			LEFT JOIN ".ROSTER." Roster ON Roster.roster_id = Schedule.roster_id
			LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = Schedule.driver_id
			LEFT JOIN ".RESERVASI." Reservasi ON Reservasi.schedule_id = Schedule.schedule_id
			WHERE 1 $StringCompany $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Array[] = $this->Sync($Row);
		}
		
		return $Array;
	}
	
	function Delete($Param) {
        $RecordCount = 0;
        $SelectQuery = array();
        if (isset($Param['schedule_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".RESERVASI." WHERE schedule_id = '".$Param['schedule_id']."'";
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
		
		if (isset($Param['schedule_id'])) {
			$DeleteQuery  = "DELETE FROM ".SCHEDULE." WHERE schedule_id = '".$Param['schedule_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
	
	function Sync($Record) {
		$Record = StripArray($Record, array('schedule_date', 'schedule_depature', 'schedule_arrival'));
		
		if (!empty($Record['schedule_date'])) {
			$DayNo = GetFormatDateCommon($Record['schedule_date'], array('FormatDate' => 'N'));
			$Record['schedule_day_title'] = (isset($this->ArrayDay[$DayNo])) ? $this->ArrayDay[$DayNo] : '';
		}
		
		if (isset($Record['schedule_date']) && isset($Record['roster_dest']) && isset($Record['schedule_depature']))
			$Record['schedule_title'] = GetFormatDateCommon($Record['schedule_date']) . ' ' . $Record['roster_dest'] . ' ' . $Record['schedule_depature'];
		
		return $Record;
	}
	
	function IsUsed($Param) {
		$ParamArray = array(
			'filter' => '['.
				'{"type":"numeric","comparison":"not","field":"Schedule.schedule_id","value":"'.$Param['schedule_id'].'"},'.
				'{"type":"numeric","comparison":"eq","field":"Schedule.car_id","value":"'.$Param['car_id'].'"},'.
				'{"type":"numeric","comparison":"eq","field":"Schedule.schedule_date","value":"'.$Param['schedule_date'].'"}'.
			']'
		);
		$ArraySchedule = $this->GetArray($ParamArray);
		
		// Current Record
		$current_departure = GetInteger($Param['schedule_depature']);
		$current_arrival = GetInteger($Param['schedule_arrival']);
		
		$IsUsed = 0;
		foreach ($ArraySchedule as $Schedule) {
			$schedule_depature = GetInteger($Schedule['schedule_depature']);
			$schedule_arrival = GetInteger($Schedule['schedule_arrival']);
			
			// for dubuging purpose
			// echo "$schedule_depature == $current_departure || $schedule_arrival == $current_departure<br />";
			
			// Jam Berangkat diantara Berangkat & Sampai
			if ($schedule_depature < $current_departure && $schedule_arrival > $current_departure) {
				$IsUsed = 1;
				break;
			}
			// Jam Sampai diantara Berangkat & Sampai
			else if ($schedule_depature < $current_arrival && $schedule_arrival > $current_arrival) {
				$IsUsed = 1;
				break;
			}
			// Jam Berangkat / Sampai = Berangkat / Sampai
			else if ($schedule_depature == $current_departure || $schedule_arrival == $current_arrival) {
				$IsUsed = 1;
				break;
			}
			// Jam Berangkat	/	Sampai sebelum	dan sesudah Berangkat	/	Sampai
			// 07:00			/	11:00			dan			08:00		/	10:00
			else if ($schedule_depature > $current_departure && $schedule_arrival < $current_arrival) {
				$IsUsed = 1;
				break;
			}
		}
		
		return array('Result' => $IsUsed);
	}
}