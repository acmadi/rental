<?php

class roster extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'roster' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateRoster') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			$Result = $this->Roster_model->Update($_POST);
		} else if ($Action == 'DeteleRosterByID') {
			$Result = $this->Roster_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/roster' );
    }
}