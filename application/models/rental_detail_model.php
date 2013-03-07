<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rental_Detail_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array(
			'rental_detail_id', 'rental_id', 'car_id', 'driver_id', 'rental_price_id', 'rental_status_id', 'car_condition_id', 'date_out', 'date_in',
			'destination', 'driver_fee', 'driver_duration', 'car_condition_out', 'car_condition_in', 'guaranty', 'user_accept_rent', 'user_accept_in',
			'rental_detail_jumlah', 'rental_detail_fuel', 'rental_detail_odometer', 'rental_detail_overtime', 'rental_detail_kerusakan',
			'rental_detail_discount', 'rental_detail_cost'
		);
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['rental_detail_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, RENTAL_DETAIL);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['rental_detail_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, RENTAL_DETAIL);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['rental_detail_id'] = $Param['rental_detail_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function UpdateCost($rental_detail_id) {
		$Record = $this->GetByID(array('rental_detail_id' => $rental_detail_id));
		
		// Set Param
		$UpdateParam['rental_detail_id'] = $rental_detail_id;
		$UpdateParam['rental_detail_cost'] =
			($Record['rental_detail_jumlah'] * $Record['rental_price_value'])
			+ $Record['rental_detail_fuel'] + $Record['rental_detail_odometer'] + $Record['rental_detail_overtime'] + $Record['rental_detail_kerusakan']
			+ $Record['driver_fee']
			- $Record['rental_detail_discount'];
		$this->Update($UpdateParam);
	}
	
	function UpdateMaster($Param) {
		$Result = array();
		$ArrayField = $this->Field;
		array_shift($ArrayField);
		
		$UpdateQuery  = GenerateUpdateQuery($ArrayField, $Param, RENTAL_DETAIL);
		$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
		
		$Result['QueryStatus'] = '1';
		$Result['Message'] = 'Data berhasil diperbaharui.';
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['rental_detail_id'])) {
			$SelectQuery  = "
				SELECT RentalDetail.*, RentalPrice.rental_price_value
				FROM ".RENTAL_DETAIL." RentalDetail
				LEFT JOIN ".RENTAL_PRICE." RentalPrice ON RentalPrice.rental_price_id = RentalDetail.rental_price_id
				LEFT JOIN ".RENTAL_DURASI." RentalDurasi ON RentalDurasi.rental_durasi_id = RentalPrice.rental_durasi_id
				WHERE RentalDetail.rental_detail_id = '".$Param['rental_detail_id']."'
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
		$StringSearch = (isset($Param['NameLike'])) ? "AND RentalDetail.driver_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringRental = (isset($Param['rental_id'])) ? "AND RentalDetail.rental_id = '" . $Param['rental_id'] . "'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Rental.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringCustom = (!empty($Param['StringCustom'])) ? $Param['StringCustom']  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'driver_name ASC';
		
		$SelectQuery = "
			SELECT
				RentalDetail.*, Driver.driver_name, Device.device, Rental.rental_no,
				Rental.order_date, Rental.uang_muka, Rental.total_price, Rental.rental_desc,
				Customer.customer_name, Customer.customer_address, Customer.customer_phone,
				RentalStatus.rental_status_name, RentalDurasi.rental_durasi_name
			FROM ".RENTAL_DETAIL." RentalDetail
			LEFT JOIN ".RENTAL." Rental ON Rental.rental_id = RentalDetail.rental_id
			LEFT JOIN ".CUSTOMER." Customer ON Customer.customer_id = Rental.customer_id
			LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = RentalDetail.driver_id
			LEFT JOIN ".DEVICE." Device ON Device.id = RentalDetail.car_id
			LEFT JOIN ".RENTAL_STATUS." RentalStatus ON RentalStatus.rental_status_id = RentalDetail.rental_status_id
			LEFT JOIN ".RENTAL_PRICE." RentalPrice ON RentalPrice.rental_price_id = RentalDetail.rental_price_id
			LEFT JOIN ".RENTAL_DURASI." RentalDurasi ON RentalDurasi.rental_durasi_id = RentalPrice.rental_durasi_id
			WHERE 1 $StringSearch $StringRental $StringCompany $StringCustom $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Row = $this->Sync($Row, array('date_out', 'date_in'));
			$Array[] = $Row;
		}
		
		return $Array;
	}
	
	function GetCount($Param = array()) {
		$TotalRecord = 0;
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND RentalDetail.driver_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringRental = (isset($Param['rental_id'])) ? "AND RentalDetail.rental_id = '" . $Param['rental_id'] . "'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Rental.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".RENTAL_DETAIL." RentalDetail
			LEFT JOIN ".RENTAL." Rental ON Rental.rental_id = RentalDetail.rental_id
			LEFT JOIN ".CUSTOMER." Customer ON Customer.customer_id = Rental.customer_id
			LEFT JOIN ".DRIVER." Driver ON Driver.driver_id = RentalDetail.driver_id
			LEFT JOIN ".DEVICE." Device ON Device.id = RentalDetail.car_id
			LEFT JOIN ".RENTAL_STATUS." RentalStatus ON RentalStatus.rental_status_id = RentalDetail.rental_status_id
			WHERE 1 $StringSearch $StringRental $StringCompany $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function GetTotalCost($Param, $IsUpdate = true) {
		$Cost = 0;
		$ArrayRecord = $this->GetArray($Param);
		foreach ($ArrayRecord as $Record) {
			$Cost += $Record['rental_detail_cost'];
		}
		
		if ($IsUpdate) {
			$Update = array(
				'rental_id' => $Param['rental_id'],
				'total_price' => $Cost
			);
			$this->Rental_model->Update($Update);
		}
		
		return $Cost;
	}
	
	function Delete($Param) {
		if (isset($Param['rental_detail_id'])) {
			$DeleteQuery  = "DELETE FROM ".RENTAL_DETAIL." WHERE rental_detail_id = '".$Param['rental_detail_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
	
	function Sync($Row) {
		$Record = StripArray($Row, array('date_out', 'date_in'));
		
		return $Record;
	}
}