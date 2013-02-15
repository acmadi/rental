<?php

class user extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'user' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateUser') {
			$UserCheck = $this->User_model->GetByID(array('username' => $_POST['username']));
			if (count($UserCheck) > 0 && $UserCheck['user_id'] != $_POST['user_id']) {
				$Result['QueryStatus'] = '0';
				$Result['Message'] = 'Username sudah terpakai.';
			} else {
				if (!empty($_POST['password'])) {
					$_POST['password'] = md5($_POST['password']);
				}
				
				$Result = $this->User_model->Update($_POST);
				
				if (!empty($Result['user_id']) && !empty($_POST['company_id'])) {
					$this->Company_User_model->UpdateUser(array('user_id' => $Result['user_id'], 'company_id' => $_POST['company_id']));
				}
			}
		} else if ($Action == 'DeteleUserByID') {
			$Result = $this->User_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/user' );
    }
}