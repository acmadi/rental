<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Customer_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('customer_id', 'customer_name', 'customer_address', 'customer_phone', 'customer_mobile', 'customer_gender', 'company_id');
    }
	
	function Update($Param) {
		$Result = array();
		
		if (empty($Param['customer_id'])) {
			$InsertQuery  = GenerateInsertQuery($this->Field, $Param, CUSTOMER);
			$InsertResult = mysql_query($InsertQuery) or die(mysql_error());
			
			$Result['customer_id'] = mysql_insert_id();
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil disimpan.';
		} else {
			$UpdateQuery  = GenerateUpdateQuery($this->Field, $Param, CUSTOMER);
			$UpdateResult = mysql_query($UpdateQuery) or die(mysql_error());
			
			$Result['customer_id'] = $Param['customer_id'];
			$Result['QueryStatus'] = '1';
			$Result['Message'] = 'Data berhasil diperbaharui.';
		}
		
		return $Result;
	}
	
	function GetByID($Param) {
		$Array = array();
		
		if (isset($Param['customer_id'])) {
			$SelectQuery  = "
				SELECT Customer.*
				FROM ".CUSTOMER." Customer
				WHERE Customer.customer_id = '".$Param['customer_id']."'
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
		$StringSearch = (isset($Param['NameLike'])) ? "AND Customer.customer_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Customer.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'customer_name ASC';
		
		$SelectQuery = "
			SELECT Customer.*
			FROM ".CUSTOMER." Customer
			WHERE 1 $StringSearch $StringCompany $StringFilter
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
		
		$StringSearch = (isset($Param['NameLike'])) ? "AND Customer.customer_name LIKE '%" . $Param['NameLike'] . "%'"  : '';
		$StringCompany = (!empty($Param['company_id'])) ? "AND Customer.company_id = '" . $Param['company_id'] . "'"  : '';
		$StringFilter = GetStringFilter($Param);
		
		$SelectQuery = "
			SELECT COUNT(*) AS TotalRecord
			FROM ".CUSTOMER." Customer
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
        if (isset($Param['customer_id'])) {
            $SelectQuery[] = "SELECT COUNT(*) RecordCount FROM ".RENTAL." WHERE customer_id = '".$Param['customer_id']."'";
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
		
		if (isset($Param['customer_id'])) {
			$DeleteQuery  = "DELETE FROM ".CUSTOMER." WHERE customer_id = '".$Param['customer_id']."' LIMIT 1";
			$DeleteResult = mysql_query($DeleteQuery) or die(mysql_error());
        }
		
        $Result['QueryStatus'] = '1';
        $Result['Message'] = 'Data berhasil dihapus.';
		
		return $Result;
	}
}