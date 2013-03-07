<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rental_Price_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('rental_price_id', 'company_id', 'car_id', 'rental_durasi_id', 'rental_price_value');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['rental_price_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, RENTAL_PRICE);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['rental_price_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, RENTAL_PRICE);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['rental_price_id'] = $Param['rental_price_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['rental_price_id'])) {
			$SelectQuery  = "
				SELECT RentalPrice.*
				FROM ".RENTAL_PRICE." RentalPrice
				WHERE RentalPrice.rental_price_id = '".$Param['rental_price_id']."'
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
		$Param['ArrayKey'] = (isset($Param['ArrayKey'])) ? $Param['ArrayKey'] : '';
		
		$Array = array();
		$StringCar = (!empty($Param['car_id'])) ? "AND RentalPrice.car_id = '" . $Param['car_id'] . "'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND RentalPrice.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'Device.device ASC, RentalDurasi.rental_durasi_order ASC';
		
		$SelectQuery = "
			SELECT
				RentalPrice.*,
				Device.id car_id, Device.device,
				RentalDurasi.rental_durasi_id, RentalDurasi.rental_durasi_name, RentalDurasi.rental_durasi_order
			FROM ".RENTAL_PRICE." RentalPrice
			LEFT JOIN ".DEVICE." Device ON Device.id = RentalPrice.car_id
			LEFT JOIN ".RENTAL_DURASI." RentalDurasi ON RentalDurasi.rental_durasi_id = RentalPrice.rental_durasi_id
			WHERE 1 $StringCar $StringCompany $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Row = StripArray($Row);
			
			if ($Param['ArrayKey'] == 'rental_price_id') {
				$Array[$Row['rental_price_id']] = $Row;
			} else {
				$Array[] = $Row;
			}
		}
		
		return $Array;
	}
	
	function GetCount($Param = array()) {
		$TotalRecord = 0;
		
		$StringCar = (!empty($Param['car_id'])) ? "AND RentalPrice.car_id = '" . $Param['car_id'] . "'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND RentalPrice.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".RENTAL_PRICE." RentalPrice
			LEFT JOIN ".DEVICE." Device ON Device.id = RentalPrice.car_id
			LEFT JOIN ".RENTAL_DURASI." RentalDurasi ON RentalDurasi.rental_durasi_id = RentalPrice.rental_durasi_id
			WHERE 1 $StringCar $StringCompany $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function Delete($Param) {
		$DeleteQuery  = "DELETE FROM ".RENTAL_PRICE." WHERE rental_price_id = '".$Param['rental_price_id']."' LIMIT 1";
		$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}