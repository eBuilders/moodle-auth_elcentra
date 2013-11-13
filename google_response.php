<?php
require_once('../../config.php');
require_once '../../lib/pluginlib.php';
require_once 'eblib/google.php';
require_once 'eblib/misc.php';

$error = optional_param("error", false, PARAM_RAW);

if($error!==false) {
	if($error == "access_denied") {
		loginDenied("google");
	} else {
		throw new moodle_exception("Google returned an error: ".$error);
	}
}

$code = required_param('code', PARAM_RAW);
$state = required_param("state", PARAM_RAW);

global $PAGE;

$PAGE->set_url("/auth/elcentra/google_response.php", array("code"=>$code, "state"=>$state));

$pluginManager = plugin_manager::instance();

if(!$pluginManager->get_plugin_info("auth_elcentra", true)->is_enabled()) {
	throw new moodle_exception("Enable elcentra plugin");
}

if(isset($_SESSION['google_login']['state']) && isset($_GET['state']) && ($_SESSION['google_login']['state']==$state)) {
	$google = new EbuildersGoogle();
	
	$conf = get_config("auth/elcentra");

	$googleConfig = array(
		"app_id"=>$conf->googleclientid,
		"app_secret"=>$conf->googleclientsecret,
		"base_url"=>$conf->google_base_url,
		"token_access_url"=>$conf->google_token_access_url,
		"retrieval_url"=>$conf->google_retrieval_url,
		"scope"=>$conf->google_scope,
	);
	
	if($googleConfig['app_id']=="" || $googleConfig['app_secret']=="") {
		throw new moodle_exception("Google login is not configured. Contact admin");
	}
	
	$google->setConfig($googleConfig);
	$googleReturn = $google->receiveResponse($code);
	
	$prefix = "elcentra_google_";
	
	$accountDetails = array(
			"$prefix".$googleReturn->id, //Username
			$googleReturn->email, //Email
			$googleReturn->given_name,
			$googleReturn->family_name,
			"", //Country
			"", //City
			"", //Timezone
			$googleReturn->verified_email, //Verified
			);
	
	require 'auth.php';
	$elcentraPlugin = new auth_plugin_elcentra();
	$elcentraPlugin->elcentraProcessResponse($accountDetails);
}