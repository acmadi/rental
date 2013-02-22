<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Menu_Item_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }
	
	function GetTree($Param = array()) {
		$Param['IsTree'] = (isset($Param['IsTree'])) ? $Param['IsTree'] : 1;
		
		$StringFilter = GetStringFilter($Param);
		
		$PageOffset = (isset($Param['start']) && !empty($Param['start'])) ? $Param['start'] : 0;
		$PageLimit = (isset($Param['limit']) && !empty($Param['limit'])) ? $Param['limit'] : 100;
        $StringSorting = (isset($Param['sort'])) ? GetStringSorting($Param['sort']) : 'MenuGroup.menu_group_order ASC, MenuItem.menu_item_order ASC';
		
		$Array = array();
		$SelectQuery = "
			SELECT MenuItem.*, MenuGroup.menu_group_name, MenuGroup.menu_group_order, MenuCompany.menu_company_active
			FROM ".MENU_ITEM." MenuItem
			LEFT JOIN ".MENU_GROUP." MenuGroup ON MenuGroup.menu_group_id = MenuItem.menu_group_id
			LEFT JOIN ".MENU_COMPANY." MenuCompany ON MenuCompany.menu_item_id = MenuItem.menu_item_id
			WHERE 1 $StringFilter
			GROUP BY menu_item_id
			ORDER BY $StringSorting
			LIMIT $PageOffset, $PageLimit
		";
		$SelectResult = mysql_query($SelectQuery) or die(mysql_error());
		while (false !== $Row = mysql_fetch_assoc($SelectResult)) {
			$Row = StripArray($Row);
			$Array[] = $Row;
		}
		
		if ($Param['IsTree'] == 1) {
			$ArrayMenu = array();
			foreach ($Array as $Key => $Row) {
				$ArrayMenu[$Row['menu_group_name']][] = $Row;
			}
		} else {
			$ArrayMenu = $Array;
		}
		
		return $ArrayMenu;
	}
}