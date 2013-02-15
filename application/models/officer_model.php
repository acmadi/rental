<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Officer_model extends CI_Model {
	function __construct() {
        parent::__construct();
		
		$this->Field = array('id', 'nip', 'nama', 'idkesatuan', 'ponsel', 'bbm');
    }
	
	function GetArray($Param = array()) {
		$Array = array();
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 25;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'nama ASC';
		
		$SelectQuery = "
			SELECT Officer.*
			FROM ".OFFICER." Officer
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
}