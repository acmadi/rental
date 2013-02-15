<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Day_model extends CI_Model {
	function GetArray($Param = array()) {
		$Param['IsHash'] = (isset($Param['IsHash'])) ? $Param['IsHash'] : 0;
		
		$Array = array(
			array('id' => 1, 'title' => 'Senin'),
			array('id' => 2, 'title' => 'Selasa'),
			array('id' => 3, 'title' => 'Rabu'),
			array('id' => 4, 'title' => 'Kamis'),
			array('id' => 5, 'title' => 'Jum\'at'),
			array('id' => 6, 'title' => 'Sabtu'),
			array('id' => 7, 'title' => 'Minggu')
		);
		
		if ($Param['IsHash'] == 1) {
			$ArrayTemp = array();
			foreach ($Array as $Temp) {
				$ArrayTemp[$Temp['id']] = $Temp['title'];
			}
			$Array = $ArrayTemp;
		}
		
		return $Array;
	}
}