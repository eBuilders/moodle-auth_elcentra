<?php
//ebuilders.in

class EbuildersVk {
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
		
		$vkConfig = $this->config;
		$buildUrl=$vkConfig['base_url'];
		$buildUrl.="client_id=".$vkConfig['app_id'];
		$buildUrl.="&scope=".$vkConfig['scope'];
		$state = randomString();
		$_SESSION['vk_login']['state']=$state;
		$buildUrl.="&state=$state";
		$buildUrl.="&redirect_uri=".htmlspecialchars($CFG->wwwroot."/auth/elcentra/vk_response.php");
		header("Location: $buildUrl");
		exit;
	}
	
	public function receiveResponse($code) {
		global $vkConfig;
		
		$vkConfig = $this->config;
		$buildUrl = $vkConfig['token_access_url'];
		$buildUrl.="client_id=".trim($vkConfig['app_id']);
		$buildUrl.="&client_secret=".trim($vkConfig['app_secret']);
		$buildUrl.="&redirect_uri=".htmlspecialchars($this->URL);
		$buildUrl.="&code=".$code;
        echo $buildUrl;
		$responseText = file_get_contents($buildUrl);
		$responseArray = (array)json_decode($responseText);
		if(!isset($responseArray['access_token'])) {
			throw new moodle_exception("Unexpected error");
		}
		$accessToken = $responseArray['access_token'];
		$buildUrl = $vkConfig['retrieval_url'];
		$buildUrl.="&access_token=$accessToken";
		$dataResponse = file_get_contents($buildUrl);
		$details = (array)json_decode($dataResponse);
		unset($_SESSION['vk_login']);
		return $details['response']['0'];
	} 
}