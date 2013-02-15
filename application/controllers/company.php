<?php

class company extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'company' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateCompany') {
			$Result = $this->Company_model->Update($_POST);
		} else if ($Action == 'DeteleCompanyByID') {
			$Result = $this->Company_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/company' );
    }
}