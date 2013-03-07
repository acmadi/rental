<?php

class typeahead extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
		
		$Record = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'Customer') {
			$Record = $this->Customer_model->GetArray($_POST);
		}
		
		$Result = array('options' => $Record );
		echo json_encode($Result);
    }
}