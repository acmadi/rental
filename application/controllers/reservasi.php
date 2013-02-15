<?php

class reservasi extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'reservasi' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateReservasi') {
			$_POST['company_id'] = $this->User_model->GetCompanyID();
			$Result = $this->Reservasi_model->Update($_POST);
		} else if ($Action == 'DeteleReservasiByID') {
			$Result = $this->Reservasi_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/reservasi' );
    }
}