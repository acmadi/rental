<?php

class dashboard extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
		$IsLogin = $this->User_model->IsLogin();
		
		if ($IsLogin) {
			$User = $this->User_model->GetUser();
			$User = $this->User_model->GetByID(array('user_id' => $User['id']));
			$this->User_model->SetCompany($User);
			
			$this->load->view( 'welcome' );
		} else {
			$this->load->view( 'login' );
		}
    }
	
	function logout() {
		setcookie("ci_session", '', time()+3600*24,'/');
		$_SESSION = array();
		header('Location: ' . $this->config->item('base_url'));
		exit();
	}
}

