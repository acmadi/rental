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
		} else if ($Action == 'GetDriverByID') {
			$Result = $this->Driver_model->GetByID($_POST);
		} else if ($Action == 'DeteleDriverByID') {
			$Result = $this->Driver_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/driver' );
    }
}