<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Device_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Table = 'devices';
		$this->Field = array('id', 'nopol', 'deviceid', 'idkategori', 'idpetugas', 'nolambung', 'msisdn', 'passgps', 'disabled');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['device_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, $this->Table);
			$InsertResult = mysql_query($InsertQuery, $this->config->item('tracking_conn')) or die(mysql_error());
			
			$Result['device_id'] = mysql_insert_id($this->config->item('tracking_conn'));
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$Param['id'] = $Param['device_id'];
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, $this->Table);
			$UpdateResult = mysql_query($UpdateQuery, $this->config->item('tracking_conn')) or die(mysql_error());
			
			$Result['device_id'] = $Param['device_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['device_id'])) {
			$SelectQuery  = "
				SELECT Device.*
				FROM ".DEVICE." Device
				WHERE Device.id = '".$Param['device_id']."'
				LIMIT 1
			";
		} else if (isset($Param['deviceid'])) {
			$SelectQuery  = "
				SELECT Device.*
				FROM ".DEVICE." Device
				WHERE Device.deviceid = '".$Param['deviceid']."'
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
		$StringCompany = (!empty($Param['company_id'])) ? "AND DeviceCompany.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'nopol ASC';
		
		$SelectQuery = "
			SELECT Device.*, Company.company_id, Company.company_name, DeviceCategory.jeniskejadianName
			FROM ".DEVICE." Device
			LEFT JOIN ".DEVICE_COMPANY." DeviceCompany ON DeviceCompany.device_id = Device.id
			LEFT JOIN ".DEVICE_CATEGORY." DeviceCategory ON DeviceCategory.jeniskejadianId = Device.idkategori
			LEFT JOIN ".COMPANY." Company ON Company.company_id = DeviceCompany.company_id
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
		$StringCompany = (!empty($Param['company_id'])) ? "AND DeviceCompany.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".DEVICE." Device
			LEFT JOIN ".DEVICE_COMPANY." DeviceCompany ON DeviceCompany.device_id = Device.id
			LEFT JOIN ".COMPANY." Company ON Company.company_id = DeviceCompany.company_id
			WHERE 1 $StringCompany $StringFilter
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
        if (isset($Param['device_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".RENTAL_DETAIL." WHERE car_id = '".$Param['device_id']."'";
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
		
		if (isset($Param['device_id'])) {
			$DeleteQuery  = "DELETE FROM ".DEVICE." WHERE id = '".$Param['device_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery, $this->config->item('tracking_conn')) or die(mysql_error());
			
			$DeleteQuery  = "DELETE FROM ".DEVICE_COMPANY." WHERE device_id = '".$Param['device_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
	
	function Sync($Row) {
		$Record = StripArray($Row, array('company_id'));
		$Record['device_id'] = $Record['id'];
		
		return $Record;
	}
}