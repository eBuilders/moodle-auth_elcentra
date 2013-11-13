<?php 
//ebuilders.in

class EbuildersGoogle {
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
		$googleConfig = $this->config;
		
		$buildUrl=$googleConfig['base_url'];
		$buildUrl.="client_id=".$googleConfig['app_id'];
		$buildUrl.="&scope=".$googleConfig['scope'];
		$state = randomString();
		$_SESSION['google_login']['state']=$state;
		$buildUrl.="&state=$state";
		$buildUrl.="&response_type=code";
		$buildUrl.="&redirect_uri=".($CFG->wwwroot."/auth/elcentra/google_response.php");
		header("Location: $buildUrl");
		exit;
	}
	
	public function receiveResponse($code) {
		$googleConfig = $this->config;
		
		$socket = curl_init($googleConfig['token_access_url']);
		$header = array();$data=array();
		$header[]="Content-Type: application/x-www-form-urlencoded";
		$data["client_id"] = $googleConfig['app_id'];
		$data["client_secret"]= $googleConfig['app_secret'];
		$data["redirect_uri"]= ($this->URL);
		$data["code"]= $code;
		$data["grant_type"]= "authorization_code";
		$data["scope"]="";
		
		$data = http_build_query($data, null, "&");
		
		curl_setopt($socket, CURLOPT_CUSTOMREQUEST, "POST");
    	curl_setopt($socket, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($socket, CURLOPT_USERAGENT, "ebuilders");
    	curl_setopt($socket, CURLOPT_REFERER, $this->URL);
    	curl_setopt($socket, CURLOPT_FOLLOWLOCATION, 0);
    	curl_setopt($socket, CURLOPT_FAILONERROR, false);
    	curl_setopt($socket, CURLOPT_HEADER, false);
    	curl_setopt($socket, CURLOPT_SSL_VERIFYPEER, false);
    	
    	curl_setopt($socket, CURLOPT_POSTFIELDS, $data);
    	
    	if ($header && is_array($header)) {
    		curl_setopt($socket, CURLOPT_HTTPHEADER, array_unique($header));
    	}
		
		$result = curl_exec($socket);
		
		$result = json_decode($result);
		
		if(!isset($result->access_token)) {
			throw new moodle_exception("Unexpected error");
		}
		
		$accessToken = $result->access_token;
		$buildUrl = $googleConfig['retrieval_url'];
		$buildUrl.="&access_token=$accessToken";
		$dataResponse = file_get_contents($buildUrl);
		$details = json_decode($dataResponse);
		
		unset($_SESSION['google_login']);
		
		return $details;
	} 
}