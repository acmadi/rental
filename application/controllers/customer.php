<?php

class customer extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'customer' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateCustomer') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			$Result = $this->Customer_model->Update($_POST);
		} else if ($Action == 'GetCustomerByID') {
			$Result = $this->Customer_model->GetByID($_POST);
		/*
		// Will remove is no issue until 1 Maret 2013
		} else if ($Action == 'UpdateListCustomer') {
			$ArrayTemp = json_decode($_POST['RawRecord']);
			foreach ($ArrayTemp as $ArrayObject) {
				$Array = (array)$ArrayObject;
				$Result = $this->Customer_model->Update($Array);
			}
		/*	*/
		} else if ($Action == 'DeteleCustomerByID') {
			$Result = $this->Customer_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/customer' );
    }
}