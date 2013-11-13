<?php
//ebuilders.in

class EbuildersFacebook {
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
		
		$facebookConfig = $this->config;
		$buildUrl=$facebookConfig['base_url'];
		$buildUrl.="client_id=".$facebookConfig['app_id'];
		$buildUrl.="&scope=".$facebookConfig['scope'];
		$state = randomString();
		$_SESSION['facebook_login']['state']=$state;
		$buildUrl.="&state=$state";
		$buildUrl.="&redirect_uri=".htmlspecialchars($CFG->wwwroot."/auth/elcentra/facebook_response.php");

		header("Location: $buildUrl");
		exit;
	}
	
	public function receiveResponse($code) {
		global $facebookConfig;
		$facebookConfig = $this->config;
		
		$buildUrl = $facebookConfig['token_access_url'];
		$buildUrl.="client_id=".$facebookConfig['app_id'];
		$buildUrl.="&client_secret=".$facebookConfig['app_secret'];
		$buildUrl.="&redirect_uri=".htmlspecialchars($this->URL);
		$buildUrl.="&code=".$code;

		$responseText = file_get_contents($buildUrl);
		parse_str($responseText,$responseArray);
		if(!isset($responseArray['access_token'])) {
			throw new moodle_exception("Unexpected error");
		}
		
		$accessToken = $responseArray['access_token'];
		
		$buildUrl = $facebookConfig['retrieval_url'];
		$buildUrl.="&access_token=$accessToken";
		$dataResponse = file_get_contents($buildUrl);
		$details = json_decode($dataResponse);
		
		unset($_SESSION['facebook_login']);
		
		return $details;
	} 
}