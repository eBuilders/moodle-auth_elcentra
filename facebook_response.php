<?php
require_once('../../config.php');
require_once '../../lib/pluginlib.php';
require_once 'eblib/facebook.php';
require_once 'eblib/misc.php';

$error = optional_param("error", false, PARAM_RAW);

if($error!==false) {
	if($error == "access_denied") {
		loginDenied("facebook");
	} else {
		$errorCode = required_param("error_code", PARAM_RAW);
		$errorDesc = required_param("error_description", PARAM_RAW);
		throw new moodle_exception("$errorDesc - ($error: $errorCode)");
	}
}

$code = required_param('code', PARAM_RAW);
$state = required_param("state", PARAM_RAW);

global $PAGE;

$PAGE->set_url("/auth/elcentra/facebook_response.php", array("code"=>$code, "state"=>$state));

$pluginManager = plugin_manager::instance();

if(!$pluginManager->get_plugin_info("auth_elcentra", true)->is_enabled()) {
	throw new moodle_exception("Enable elcentra plugin");
}

if(isset($_SESSION['facebook_login']['state']) && isset($_GET['state']) && ($_SESSION['facebook_login']['state']==$state)) {
	$facebook = new EbuildersFacebook();
	$conf = get_config("auth/elcentra");

	$facebookConfig = array(
		"app_id"=>$conf->facebookclientid,
		"app_secret"=>$conf->facebookclientsecret,
		"base_url"=>$conf->facebook_base_url,
		"token_access_url"=>$conf->facebook_token_access_url,
		"retrieval_url"=>$conf->facebook_retrieval_url,
		"scope"=>$conf->facebook_scope
		);
	
	if($facebookConfig['app_id']=="" || $facebookConfig['app_secret']=="") {
		throw new moodle_exception("Facebook login is not configured. Contact admin");
	}
	
	$facebook->setConfig($facebookConfig);
	$facebookReturn = $facebook->receiveResponse($code);
	
	$prefix = "elcentra_fb_";
	
	$accountDetails = array(
			"$prefix".$facebookReturn->id, //Username
			$facebookReturn->email, //Email
			$facebookReturn->first_name,
			$facebookReturn->last_name,
			"", //Country
			"", //City
			$facebookReturn->timezone, //Timezone
			$facebookReturn->verified, //Verified
			);
	
	require 'auth.php';
	$elcentraPlugin = new auth_plugin_elcentra();
	$elcentraPlugin->elcentraProcessResponse($accountDetails);
}