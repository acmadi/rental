<?php

class rental_detail extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateRentalDetail') {
			$Result = $this->Rental_Detail_model->Update($_POST);
			$this->Rental_Detail_model->UpdateCost($Result['rental_detail_id']);
			
			if (!empty($_POST['rental_id'])) {
				$Cost = $this->Rental_Detail_model->GetTotalCost(array('rental_id' => $_POST['rental_id']));
				$Result['TotalCost'] = $Cost;
			}
		} else if ($Action == 'UpdateRentalByMaster') {
			$Result = $this->Rental_Detail_model->UpdateMaster($_POST);
		} else if ($Action == 'DeteleRentalDetailByID') {
			$Result = $this->Rental_Detail_model->Delete($_POST);
			
			$Cost = $this->Rental_Detail_model->GetTotalCost(array('rental_id' => $_POST['rental_id']));
			$Result['TotalCost'] = $Cost;
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/rental_detail' );
    }
	
	function grid_dash() {
        $this->load->view( 'grid/rental_dash' );
	}
}