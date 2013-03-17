<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Merge_model extends CI_Model {
	function __construct() {
        parent::__construct();
    }
	
	function GetArray($Param) {
		$Array = array();
		$Param['month'] = (isset($Param['month'])) ? $Param['month'] : date("m");
		
		// Get Array Rental
		$ParamRental['company_id'] = $this->User_model->GetCompanyID();
		$ParamRental['StringCustom'] = "AND MONTH(RentalDetail.date_out) = '".$Param['month']."'";
		$ArrayRental = $this->Rental_Detail_model->GetArray($ParamRental);
		
		// Get Array Travel
		$ParamTravel['company_id'] = $this->User_model->GetCompanyID();
		$ParamTravel['StringCustom'] = "AND MONTH(Schedule.schedule_date) = '".$Param['month']."'";
		$ArrayTravel = $this->Schedule_model->GetArray($ParamTravel);
		
		// Merge Array Rental
		foreach ($ArrayRental as $Rental) {
			$ArrayDate = ConvertDateToArray($Rental['date_out']);
			$Array[] = array(
				'title' => $Rental['device'].' '.$Rental['rental_no'],
				'start_text' => 'new Date('.$ArrayDate['Year'].', '.($ArrayDate['Month'] - 1).', '.$ArrayDate['Day'].')',
				'color' => '#AEDB97',
				'textColor' => '#3D641B',
				'is_rental' => 1,
				'desc' => json_encode($Rental)
			);
		}
		
		// Merge Array Travel
		foreach ($ArrayTravel as $Travel) {
			$ArrayDate = ConvertDateToArray($Travel['schedule_date']);
			$Array[] = array(
				'title' => $Travel['device'].' '.$Travel['driver_name'],
				'start_text' => 'new Date('.$ArrayDate['Year'].', '.($ArrayDate['Month'] - 1).', '.$ArrayDate['Day'].')',
				'color' => '#BCDEEE',
				'textColor' => '#1C546D',
				'is_travel' => 1,
				'desc' => json_encode($Travel)
			);
		}
		
		return $Array;
	}
}