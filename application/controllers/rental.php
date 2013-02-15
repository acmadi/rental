<?php

class rental extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'rental' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateRental') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			$Result = $this->Rental_model->Update($_POST);
		/*
		// Will remove is no issue until 1 Maret 2013
		} else if ($Action == 'UpdateListRental') {
			$ArrayTemp = json_decode($_POST['RawRecord']);
			foreach ($ArrayTemp as $ArrayObject) {
				$Array = (array)$ArrayObject;
				$Result = $this->Rental_model->Update($Array);
			}
		/*	*/
		} else if ($Action == 'GetRentalNo') {
			$CompanyID = $this->User_model->GetCompanyID();
			$Result = $this->Rental_model->GetNextRentalNo(array('company_id' => $CompanyID));
		} else if ($Action == 'DeteleRentalByID') {
			$Result = $this->Rental_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid($Page = 'rental') {
        $this->load->view( 'grid/' . $Page );
    }
}