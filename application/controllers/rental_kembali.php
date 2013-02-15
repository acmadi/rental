<?php

class rental_kembali extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'rental_kembali' );
    }
	
    function grid() {
        $this->load->view( 'grid/rental_kembali' );
    }
}