<?php
//ebuilders.in

class EbuildersTwitter {
	var $URL;
	var $config;
	
	function __construct() {
		$this->URL = "http://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'];
	}
	
	function setConfig($configArray) {
		$this->config = $configArray;
	}
	
	public function createSignature($authenticationHeader,$tokenSecret=null,$url=null,$method="POST") {
		$twitterConfig = $this->config;
		
		$signatureKey = $twitterConfig["consumer_secret"]."&".$tokenSecret;
		
		$signatureBaseString = "$method&".urlencode(($url==null)?$twitterConfig['token_request_url']:$url)."&";
		$signatureBaseStringArray = array();
		foreach($authenticationHeader as $l=>$v) {
			$signatureBaseStringArray[]=urlencode("$l=$v");
		}
		$signatureBaseString.=implode("%26", $signatureBaseStringArray);
		return base64_encode(hash_hmac("sha1", $signatureBaseString, $signatureKey, true));
	}
	
	function buildTokenRequestAuthenticationHeader($tokenSecret=null) {
		global $CFG;
		$twitterConfig = $this->config;
		
		$authHeader= 'Authorization: OAuth ';
		$authTemp=array();
		
		$authenticationHeader=array();
		$authenticationHeader['oauth_callback']=urlencode($CFG->wwwroot."/auth/elcentra/twitter_response.php");
		$authenticationHeader['oauth_consumer_key'] = urlencode($twitterConfig["consumer_key"]);
		$authenticationHeader['oauth_nonce'] = randomString(20);
		$authenticationHeader['oauth_signature_method'] = "HMAC-SHA1";
		$authenticationHeader['oauth_timestamp'] = mktime();
		$authenticationHeader['oauth_version'] = "1.0";
		
		$authenticationHeader['oauth_signature']=urlencode($this->createSignature($authenticationHeader,$tokenSecret));
		
		foreach($authenticationHeader as $l=>$v) {
			$authTemp[]=$l.'="'.($v).'"';
		}
		$authHeader.=implode(", ", $authTemp);
				
		return $authHeader;
	}
	
	function buildAccessTokenAuthenticationHeader($tokenSecret=null,$token=null,$url=null,$method="POST", $oauthVerifier=null) {
		$twitterConfig = $this->config;
	
		$authHeader= 'Authorization: OAuth ';
		$authTemp=array();
	
		$authenticationHeader=array();
		$authenticationHeader['oauth_consumer_key'] = urlencode($twitterConfig["consumer_key"]);
		$authenticationHeader['oauth_nonce'] = randomString(20);
		$authenticationHeader['oauth_signature_method'] = "HMAC-SHA1";
		$authenticationHeader['oauth_timestamp'] = mktime();
		$authenticationHeader['oauth_token'] = ($token==null)?$_SESSION['twitter_login']['oauth_token']:$token;
		$authenticationHeader['oauth_version'] = "1.0";
		if($oauthVerifier!=null)
			$authenticationHeader['oauth_verifier'] = $oauthVerifier;
		
		$authenticationHeader['oauth_signature']=urlencode($this->createSignature($authenticationHeader,$tokenSecret,$url,$method));
	
		foreach($authenticationHeader as $l=>$v) {
			$authTemp[]=$l.'="'.($v).'"';
		}
		$authHeader.=implode(", ", $authTemp);
	
		return $authHeader;
	}
	
	function buildDataAuthenticationHeader($tokenSecret,$token,$url) {
		$twitterConfig = $this->config;
	
		$authHeader= 'Authorization: OAuth ';
		$authTemp=array();
	
		$authenticationHeader=array();
		$authenticationHeader['oauth_consumer_key'] = urlencode($twitterConfig["consumer_key"]);
		$authenticationHeader['oauth_nonce'] = randomString(20);
		$authenticationHeader['oauth_signature_method'] = "HMAC-SHA1";
		$authenticationHeader['oauth_timestamp'] = mktime();
		$authenticationHeader['oauth_token'] = $token;
		$authenticationHeader['oauth_version'] = "1.0";
	
		$authenticationHeader['oauth_signature']=urlencode($this->createSignature($authenticationHeader,$tokenSecret,$url));
	
		foreach($authenticationHeader as $l=>$v) {
			$authTemp[]=$l.'="'.($v).'"';
		}
		$authHeader.=implode(", ", $authTemp);
	
		return $authHeader;
	}
	
	public function sendAccessRequest() {
		$twitterConfig = $this->config;
		
		$socket = curl_init($twitterConfig['token_request_url']);
		$header = array();$data=array();
		
		$header[]=$this->buildTokenRequestAuthenticationHeader();
		
		curl_setopt($socket, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($socket, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($socket, CURLOPT_USERAGENT, "ebuilders");
		curl_setopt($socket, CURLOPT_REFERER, $this->URL);
		curl_setopt($socket, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($socket, CURLOPT_FAILONERROR, false);
		curl_setopt($socket, CURLOPT_HEADER, false);
		curl_setopt($socket, CURLOPT_SSL_VERIFYPEER, false);
		
		if ($header && is_array($header)) {
			curl_setopt($socket, CURLOPT_HTTPHEADER, array_unique($header));
		}
		
		$result = curl_exec($socket);
		$resultArray = array();
		parse_str($result,$resultArray);
		
		$_SESSION['twitter_login']['oauth_token'] = $resultArray['oauth_token'];
		$_SESSION['twitter_login']['oauth_secret'] = $resultArray['oauth_token_secret'];
		
		header("Location: ".$twitterConfig['authorize_url']."?oauth_token=".$resultArray['oauth_token']);
		exit;
	}
	
	public function receiveResponse($oauthVerifier, $oauthToken) {
		$twitterConfig = $this->config;
		$socket = curl_init($twitterConfig['token_access_url']);
		$header = array();$data=array();
		
		$header[]=$this->buildAccessTokenAuthenticationHeader($_SESSION['twitter_login']['oauth_secret'], $oauthToken, null, "POST", $oauthVerifier);
		
		curl_setopt($socket, CURLOPT_CUSTOMREQUEST, "POST");
		curl_setopt($socket, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($socket, CURLOPT_USERAGENT, "ebuilders");
		curl_setopt($socket, CURLOPT_REFERER, $this->URL);
		curl_setopt($socket, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($socket, CURLOPT_FAILONERROR, false);
		curl_setopt($socket, CURLOPT_HEADER, false);
		curl_setopt($socket, CURLOPT_SSL_VERIFYPEER, false);
		
		if ($header && is_array($header)) {
			curl_setopt($socket, CURLOPT_HTTPHEADER, array_unique($header));
		}
		
		$result = curl_exec($socket);
		curl_close($socket);
		
		$resultArray = array();
		parse_str($result, $resultArray);
		
		if(!isset($resultArray['oauth_token_secret']) || !isset($resultArray['oauth_token'])) {
			throw new moodle_exception("Unexpected error");
		}
		
		$dataRequest="https://api.twitter.com/1.1/account/verify_credentials.json";
		
		$socket = curl_init($dataRequest);
		unset($header);
		$header = array();		
		$header[]=$this->buildAccessTokenAuthenticationHeader($resultArray['oauth_token_secret'],$resultArray['oauth_token'],$dataRequest,"GET");
		
		curl_setopt($socket, CURLOPT_CUSTOMREQUEST, "GET");
		curl_setopt($socket, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($socket, CURLOPT_USERAGENT, "ebuilders");
		curl_setopt($socket, CURLOPT_REFERER, $this->URL);
		curl_setopt($socket, CURLOPT_FOLLOWLOCATION, 0);
		curl_setopt($socket, CURLOPT_FAILONERROR, false);
		curl_setopt($socket, CURLOPT_HEADER, false);
		curl_setopt($socket, CURLOPT_SSL_VERIFYPEER, false);
		
		if ($header && is_array($header)) {
			curl_setopt($socket, CURLOPT_HTTPHEADER, array_unique($header));
		}
		
		$result = curl_exec($socket);
		$result = json_decode($result);
		
		unset($_SESSION['twitter_login']);
		return $result;
	}
}