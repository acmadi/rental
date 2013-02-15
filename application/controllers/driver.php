<?php

class driver extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'driver' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateDriver') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			$Result = $this->Driver_model->Update($_POST);
		/*
		// Will remove is no issue until 1 Maret 2013
		} else if ($Action == 'UpdateListDriver') {
			$ArrayTemp = json_decode($_POST['RawRecord']);
			foreach ($ArrayTemp as $ArrayObject) {
				$Array = (array)$ArrayObject;
				$Result = $this->Driver_model->Update($Array);
			}
		/*	*/
		} else if ($Action == 'DeteleDriverByID') {
			$Result = $this->Driver_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/driver' );
    }
}