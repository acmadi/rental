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
			if (! $this->Widget_Reservasi_model->IsAllowSubmit()) {
				$Result['QueryStatus'] = '1';
				$Result['Message'] = 'Maaf, anda dapat melakukan pengisian setelah 1 jam lagi.';
				echo json_encode($Result);
				exit;
			}
			
			$ParamUpdate = $_POST;
			if (empty($ParamUpdate['widget_reservasi_id'])) {
				$ParamUpdate['status'] = 'pending';
			}
			$Result = $this->Widget_Reservasi_model->Update($ParamUpdate);
			
			// Set Message for Widget
			$Result['Message']  = 'Reservasi anda berhasil disimpan, harap menunggu pemberitahuan lebih lanjut dari admin.';
		} else if ($Action == 'Update') {
			$Result = $this->Widget_Reservasi_model->Update($_POST);
			if (!empty($_POST['widget_reservasi_id']) && $_POST['status'] == 'ok') {
				// Send SMS
				$this->Widget_Reservasi_model->SendSms($_POST['widget_reservasi_id']);
				
				// Send Email
				$Reservasi = $this->Widget_Reservasi_model->GetByID(array('widget_reservasi_id' => $_POST['widget_reservasi_id']));
				$Param = array(
					'Email' => $Reservasi['email'],
					'Subject' => 'Reservasi Online Report',
					'Message' => "Terima kasih reservasi anda telah berhasil diproses admin.\n\nSalam\nAdmin"
				);
				SentMail($Param);
			}
		} else if ($Action == 'Delete') {
			$Result = $this->Widget_Reservasi_model->Delete($_POST);
		}
		
		echo json_encode($Result);
	}
	
    function grid() {
        $this->load->view( 'grid/reservasi_online' );
    }
	
	/*
	// feature didnot use
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
	/*	*/
	
	// reservasi by sms
	function sms() {
		$msisdn = $_GET['msisdn'];
		$content = $_GET['content'];
		$this->Sms_Log_model->Update(array('sms_log_id' => 0, 'content' => $_SERVER['REQUEST_URI']));
		
		// check coontent
		if (empty($content)) {
			$Result['status'] = false;
			$Result['message'] = 'content kosong';
			echo json_encode($Result);
			exit;
		}
		
		$ArrayContent = explode(' ', $content, 3);
		$nama = (isset($ArrayContent[2])) ? $ArrayContent[2] : '';
		$company_id = (isset($ArrayContent[1])) ? $ArrayContent[1] : '';
		if (empty($nama) || empty($company_id)) {
			$Result['status'] = false;
			$Result['message'] = 'data nama dan perusahaan kosong';
			echo json_encode($Result);
			exit;
		}
		
		$ParamUpdate = array(
			'widget_reservasi_id' => 0,
			'nama' => $nama,
			'mobile' => $msisdn,
			'company_id' => $company_id
		);
		$this->Widget_Reservasi_model->Update($ParamUpdate);
		$Result['status'] = true;
		$Result['message'] = 'reservasi berhasil';
		echo json_encode($Result);
		exit;
	}
}