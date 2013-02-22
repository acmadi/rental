<?php

class track extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
        $this->load->view( 'track' );
    }
	
    function grid() {
        $this->load->view( 'grid/track' );
    }
}