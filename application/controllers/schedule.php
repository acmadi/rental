<?php

class schedule extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'schedule' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateSchedule') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			
			// Validation
			$Check = $this->Schedule_model->IsUsed($_POST);
			if ($Check['Result'] == 1) {
				$Result['QueryStatus'] = '0';
				$Result['Message'] = 'Gagal, Mobil sedang dipakai oleh jadwal yang lain.';
			} else {
				$Result = $this->Schedule_model->Update($_POST);
			}
		} else if ($Action == 'GetScheduleByID') {
			$Result = $this->Schedule_model->GetByID(array('schedule_id' => $_POST['schedule_id']));
		} else if ($Action == 'DeteleScheduleByID') {
			$Result = $this->Schedule_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/schedule' );
    }
	
	function view($PageView = 'report') {
		$this->load->view( 'report/schedule' );
	}
}