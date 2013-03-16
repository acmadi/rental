<?php
class api {
    function __construct() {
        $this->CI =& get_instance();
		$this->Curl = new CURL();
    }
	
	function get_token($Param) {
		date_default_timezone_set('UTC');
		$time = time();
		$hash = substr(md5($time . 'INDOCRM' . $Param['indocrm_privatekey']), 5, 8);
		$token = $time . '-' . $Param['indocrm_client_id'] . '-' . $hash;
		
		return $token;
	}
	
	function request($url, $param) {
		// Generate Token
		$ApiKey = $this->CI->Company_model->GetByID(array('company_id' => $param['company_id']));
		if (empty($ApiKey['indocrm_client_id']) || empty($ApiKey['indocrm_privatekey'])) {
			return array('api_result' => 0);
		}
		$token = $this->get_token($ApiKey);
		
		// Add Token
		$param['t'] = $token;
		$ResultJson = $this->Curl->post($url, $param);
		
		// Sync Data
		$Result = json_decode($ResultJson);
		$Result->api_result = (isset($Result->success) && $Result->success) ? 1 : 0;
		
		if (isset($Result->customer_id) && !empty($Result->customer_id)) {
			$Result->indocrm_id = $Result->customer_id;
		}
		
		unset($Result->success);
		unset($Result->customer_id);
		$Result = (array)$Result;
		
		// Debug Command
		// echo $url; print_r($Result); print_r($param); exit;
		
		return $Result;
	}
}
?>