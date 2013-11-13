<?php
//ebuilders.in

class EbuildersLinkedin {
	var $URL;
	var $config;
	
	function __construct() {
		$this->URL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	}
	
	function setConfig($configArray) {
		$this->config = $configArray;
	}
	
	public function sendAccessRequest() {
		global $CFG; 
		
		$linkedinConfig = $this->config;
		$buildUrl=$linkedinConfig['base_url'];
		$buildUrl.="response_type=code";
		$buildUrl.="&client_id=".$linkedinConfig['app_id'];
		$buildUrl.="&scope=".$linkedinConfig['scope'];
		$state = randomString();
		$_SESSION['linkedin_login']['state']=$state;
		$buildUrl.="&state=$state";
		$buildUrl.="&redirect_uri=".htmlspecialchars($CFG->wwwroot."/auth/elcentra/linkedin_response.php");

		header("Location: $buildUrl");
		exit;
	}
	
	public function receiveResponse($code) {
		global $linkedinConfig;
		$linkedinConfig = $this->config;
		
		$socket = curl_init($linkedinConfig['token_access_url']);
		
		$header = array();
		$header[]="Content-Type: application/x-www-form-urlencoded";
		
		$buildUrl="grant_type=authorization_code";
		$buildUrl.="&client_id=".$linkedinConfig['app_id'];
		$buildUrl.="&client_secret=".$linkedinConfig['app_secret'];
		$buildUrl.="&redirect_uri=".htmlspecialchars($this->URL);
		$buildUrl.="&code=".$code;
		
		curl_setopt($socket, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($socket, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($socket, CURLOPT_USERAGENT, "ebuilders");
		curl_setopt($socket, CURLOPT_REFERER, $this->URL);
		curl_setopt($socket, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($socket, CURLOPT_FAILONERROR, false);
		curl_setopt($socket, CURLOPT_HEADER, false);
		curl_setopt($socket, CURLOPT_SSL_VERIFYPEER, false);
		 
		curl_setopt($socket, CURLOPT_POSTFIELDS, $buildUrl);
		 
		if ($header && is_array($header)) {
			curl_setopt($socket, CURLOPT_HTTPHEADER, array_unique($header));
		}
		
		$result = curl_exec($socket);
		$result = json_decode($result);
		
		if(!isset($result->access_token)) {
			throw new moodle_exception("Unexpected error");
		}

		$accessToken = $result->access_token;
		
		$buildUrl = $linkedinConfig['retrieval_url'];
		$buildUrl.="&oauth2_access_token=$accessToken";
		$dataResponse = file_get_contents($buildUrl);
		$details = simplexml_load_string($dataResponse);
		
		unset($_SESSION['linkedin_login']);
		
		return $details;
	} 
}