<?php

class rental_price extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'rental_price' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateRentalPrice') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			$Result = $this->Rental_Price_model->Update($_POST);
		} else if ($Action == 'GetRentalPriceByID') {
			$Result = $this->Rental_Price_model->GetByID($_POST);
		} else if ($Action == 'DeteleRentalPriceByID') {
			$Result = $this->Rental_Price_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/rental_price' );
    }
}