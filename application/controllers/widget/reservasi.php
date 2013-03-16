<?php

class reservasi extends CI_Controller {
    function __construct() {
        parent::__construct();
    }
    
    function index() {
        $this->load->view( 'widget/reservasi' );
    }
	
	function action() {
		$Result = array();
		$Action = (isset($_POST['Action'])) ? $_POST['Action'] : '';
		
		if ($Action == 'UpdateWidgetReservasi') {
			$ParamUpdate = $_POST;
			if (empty($ParamUpdate['widget_reservasi_id'])) {
				$ParamUpdate['status'] = 'pending';
				$ParamUpdate['validate_key'] = rand(1000,9999);
			}
			$Result = $this->Widget_Reservasi_model->Update($ParamUpdate);
			
			// Sent Mail
			if (!empty($ParamUpdate['email'])) {
				$LinkValidate = $this->config->item('base_url').'/index.php/widget/reservasi/email/'.$Result['widget_reservasi_id'].'-'.EncriptPassword($ParamUpdate['validate_key']);
//				echo $LinkValidate;
				$Param = array(
					'Email' => $ParamUpdate['email'],
					'Subject' => 'Validasi Reservasi Online',
					'Message' =>
						"Terima kasih telah melakukan reservasi online pada website kami, harap klik link berikut untuk memvalidasi reservasi anda.\n\n"
						."$LinkValidate\n\n"
						."Terima Kasih"
				);
				SentMail($Param);
			}
			
			// Set Message
			$Result['Message']  = 'Reservasi anda akan diproses setelah anda melakukan validasi email / sms, ';
			$Result['Message'] .= 'silahkan mengecek email anda atau melakukan validasi sms dengan mengirim sms "LINTAS '.$Result['widget_reservasi_id'].'-'.$ParamUpdate['validate_key'].'" ke nomor XXXX';
		} else if ($Action == 'Update') {
			$Result = $this->Widget_Reservasi_model->Update($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'widget/reservasi_grid' );
    }
	
	// validate by email
	function email($validate_key = '') {
		if (empty($validate_key)) {
			$Result['status'] = false;
			$Result['message'] = 'key kosong';
			echo json_encode($Result);
			exit;
		}
		
		// check number data
		$ArrayKey = explode('-', $validate_key);
		if (count($ArrayKey) != 2) {
			$Result['status'] = false;
			$Result['message'] = 'key tidak valid';
			echo json_encode($Result);
			exit;
		}
		
		// get record data
		$Reservasi = $this->Widget_Reservasi_model->GetByID(array('widget_reservasi_id' => $ArrayKey[0]));
		if (count($Reservasi) == 0) {
			$Result['status'] = false;
			$Result['message'] = 'key tidak ditemukan';
			echo json_encode($Result);
			exit;
		}
		
		// check key validate
		if (trim($ArrayKey[1]) != EncriptPassword($Reservasi['validate_key'])) {
			$Result['status'] = false;
			$Result['message'] = 'no validasi tidak sama';
			echo json_encode($Result);
			exit;
		}
		
		$this->Widget_Reservasi_model->Update(array('widget_reservasi_id' => $ArrayKey[0], 'validate_status' => 'by email'));
		$Result['status'] = true;
		$Result['message'] = 'validasi berhasil';
		echo 'Validasi anda berhasil.<br /><br />Admin<br />Terima Kasih';
		exit;
	}
	
	// validate by sms
	function sms() {
		$validate_key = $_GET['content'];
		$this->Sms_Log_model->Update(array('sms_log_id' => 0, 'content' => $_SERVER['REQUEST_URI']));
		
		// check number data
		$ArrayKey = explode('-', $validate_key);
		if (count($ArrayKey) != 2) {
			$Result['status'] = false;
			$Result['message'] = 'key tidak valid';
			echo json_encode($Result);
			exit;
		}
		
		// get record data
		$Reservasi = $this->Widget_Reservasi_model->GetByID(array('widget_reservasi_id' => $ArrayKey[0]));
		if (count($Reservasi) == 0) {
			$Result['status'] = false;
			$Result['message'] = 'key tidak ditemukan';
			echo json_encode($Result);
			exit;
		}
		
		// check key validate
		if (trim($ArrayKey[1]) != $Reservasi['validate_key']) {
			$Result['status'] = false;
			$Result['message'] = 'no validasi tidak sama';
			echo json_encode($Result);
			exit;
		}
		
		$this->Widget_Reservasi_model->Update(array('widget_reservasi_id' => $ArrayKey[0], 'validate_status' => 'by sms'));
		$Result['status'] = true;
		$Result['message'] = 'validasi berhasil';
		echo json_encode($Result);
		exit;
	}
}