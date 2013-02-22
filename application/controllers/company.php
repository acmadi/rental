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
		} else if ($Action == 'UpdateMenu') {
			$ArrayMenuItem = json_decode($_POST['menu_item']);
			foreach ($ArrayMenuItem as $Key => $Object) {
				$Record = $this->Menu_Company_model->GetByID(array( 'company_id' => $_POST['company_id'], 'menu_item_id' => $Object->menu_item_id ));
				if (count($Record) == 0) {
					$Result = $this->Menu_Company_model->Update( array(
						'menu_company_id' => 0,
						'company_id' => $_POST['company_id'],
						'menu_item_id' => $Object->menu_item_id,
						'menu_company_active' => $Object->menu_company_active
					) );
				} else {
					$Result = $this->Menu_Company_model->Update( array(
						'menu_company_id' => $Record['menu_company_id'],
						'menu_company_active' => $Object->menu_company_active
					) );
				}
			}
		} else if ($Action == 'GetMenu') {
			$Param = array(
				'IsTree' => 0,
				'filter' => '[{"type":"numeric","comparison":"eq","value":' . $_POST['company_id'] . ',"field":"company_id"}]'
			);
			$Result = $this->Menu_Item_model->GetTree($Param);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/company' );
    }
}