<?php

class combo extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
		
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'RentalPrice') {
			$Result = $this->Rental_Price_model->GetArray($_POST);
		}
		
		echo json_encode($Result);
    }
}