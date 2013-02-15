<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rental_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('rental_id', 'rental_no', 'customer_id', 'order_date', 'uang_muka', 'total_price', 'sisa', 'rental_desc', 'rental_guarantee', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['rental_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, RENTAL);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['rental_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, RENTAL);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['rental_id'] = $Param['rental_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['rental_id'])) {
			$SelectQuery  = "
				SELECT Rental.*
				FROM ".RENTAL." Rental
				WHERE Rental.rental_id = '".$Param['rental_id']."'
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
		$StringSearch = (isset($Param['NameLike'])) ? "AND Rental.rental_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Rental.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'rental_name ASC';
		
		$SelectQuery = "
			SELECT Rental.*, Customer.customer_name, Customer.customer_address, Customer.customer_phone
			FROM ".RENTAL." Rental
			LEFT JOIN ".CUSTOMER." Customer ON Customer.customer_id = Rental.customer_id
			WHERE 1 $StringSearch $StringCompany $StringFilter
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Row = StripArray($Row, array('customer_id', 'order_date'));
			$Array[] = $Row;
		}
		
		return $Array;
	}
	
	function GetCount($Param = array()) {
		$TotalRecord = 0;
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Rental.rental_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Rental.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".RENTAL." Rental
			LEFT JOIN ".CUSTOMER." Customer ON Customer.customer_id = Rental.customer_id
			WHERE 1 $StringSearch $StringCompany $StringFilter
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$TotalRecord = $Row['TotalRecord'];
		}
		
		return $TotalRecord;
	}
	
	function GetNextRentalNo($Param = array()) {
		$RentalNo = $this->Config_model->GetByID(array('config_name' => 'Rental No', 'company_id' => $Param['company_id']));
		if (count($RentalNo) == 0) {
			$RentalNo = array(
				'config_id' => 0,
				'company_id' => $Param['company_id'],
				'config_name' => 'Rental No',
				'config_content' => 1,
				'hidden' => 0
			);
			$this->Config_model->Update($RentalNo);
		} else {
			$RentalNo['config_content'] = $RentalNo['config_content'] + 1;
			$this->Config_model->Update($RentalNo);
		}
		
		$RentalNo['config_content'] = str_pad($RentalNo['config_content'], 5, '0', STR_PAD_LEFT);
		return $RentalNo;
	}
	
	function Delete($Param) {
		/*
        $RecordCount = 0;
        $SelectQuery = array();
        if (isset($Param['rental_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".BOOK." WHERE rental_id = '".$Param['rental_id']."'";
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".TOUR_PATTERN." WHERE rental_id = '".$Param['rental_id']."'";
        }
        foreach ($SelectQuery as $Query) {
            $SelectResult = mysql_query($Query) or die(mysql_error());
            if (false !== $Row = mysql_fetch_assoc($SelectResult)) {
                $RecordCount += $Row['RecordCount'];
            }
        }
		if ($RecordCount > 0) {
            $Result['QueryStatus'] = '0';
            $Result['Message'] = 'Data already used.';
			return $Result;
		}
		/*	*/
		
		if (isset($Param['rental_id'])) {
			// Delete Rental Detail
			$DeleteQuery  = "DELETE FROM ".RENTAL_DETAIL." WHERE rental_id = '".$Param['rental_id']."'";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
			
			// Delete Rental
			$DeleteQuery  = "DELETE FROM ".RENTAL." WHERE rental_id = '".$Param['rental_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}