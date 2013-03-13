<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Widget_Reservasi_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array(
			'widget_reservasi_id', 'company_id', 'jenis', 'tujuan', 'tanggal', 'nama', 'telepon', 'email', 'alamat', 'catatan', 'status',
			'validate_status', 'validate_key'
		);
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['widget_reservasi_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, WIDGET_RESERVASI);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['widget_reservasi_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, WIDGET_RESERVASI);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['widget_reservasi_id'] = $Param['widget_reservasi_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['widget_reservasi_id'])) {
			$SelectQuery  = "
				SELECT WidgetReservasi.*
				FROM ".WIDGET_RESERVASI." WidgetReservasi
				WHERE WidgetReservasi.widget_reservasi_id = '".$Param['widget_reservasi_id']."'
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
		$StringCompany = (!empty($Param['company_id'])) ? "AND WidgetReservasi.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'tanggal ASC';
		
		$SelectQuery = "
			SELECT WidgetReservasi.*
			FROM ".WIDGET_RESERVASI." WidgetReservasi
			WHERE 1 $StringCompany $StringFilter
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
		
		$StringCompany = (!empty($Param['company_id'])) ? "AND WidgetReservasi.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".WIDGET_RESERVASI." WidgetReservasi
			WHERE 1 $StringCompany $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
		$DeleteQuery  = "DELETE FROM ".WIDGET_RESERVASI." WHERE widget_reservasi_id = '".$Param['widget_reservasi_id']."' LIMIT 1";
		$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}