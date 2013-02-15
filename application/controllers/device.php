<?php

class device extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'device' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateDevice') {
			$DeviceCheck = $this->Device_model->GetByID(array('deviceid' => $_POST['deviceid']));
			if (count($DeviceCheck) > 0 && $_POST['device_id'] != $DeviceCheck['device_id']) {
				$Result['QueryStatus'] = '0';
				$Result['Message'] = 'ID Alat tidak telah terpakai.';
			} else {
				$Result = $this->Device_model->Update($_POST);
				if (!empty($Result['device_id']) && !empty($_POST['company_id'])) {
					$this->Device_Company_model->UpdateDevice(array( 'device_id' => $Result['device_id'], 'company_id' => $_POST['company_id']));
				}
			}
		} else if ($Action == 'DeteleDeviceByID') {
			$Result = $this->Device_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/device' );
    }
}