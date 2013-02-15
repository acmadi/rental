<?php

class upload extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->User_model->LoginRequeired();
		$Action = $this->input->post('Action');
		
		if ($Action == 'UploadImage') {
			$Result['success'] = true;
			$Result['UploadFileName'] = '';
			$Result['UploadMessage'] = 'Upload Fail.';
			$Result['UploadStatus'] = 0;
			
			$Image = Upload('Image', $this->config->item('base_path') . '/images');
			if (!empty($Image['FileDirName'])) {
				$Result['UploadStatus'] = 1;
				$Result['UploadMessage'] = 'Upload successful';
				$Result['UploadFileName'] = $Image['FileDirName'];
				
				$PathFileName = $this->config->item('base_path') . '/images/upload/' . $Result['UploadFileName'];
				$ImageProperty = @getimagesize($PathFileName);
				if ($ImageProperty) {
					$Result['width'] = $ImageProperty[0];
					$Result['height'] = $ImageProperty[1];
				}
			}
		} else if ($Action == 'UploadDocument') {
			$Result['success'] = true;
			$Result['UploadFileName'] = '';
			$Result['UploadMessage'] = 'Upload Fail.';
			$Result['UploadStatus'] = 0;
			
			$Document = Upload('Document', $this->config->item('base_path') . '/static/document');
			if (!empty($Document['FileDirName'])) {
				$Result['UploadStatus'] = 1;
				$Result['UploadMessage'] = 'Upload successful';
				$Result['UploadFileName'] = $Document['FileDirName'];
			}
		}
		
		echo json_encode($Result);
    }
}

