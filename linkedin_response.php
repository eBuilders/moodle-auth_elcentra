<?php
require_once('../../config.php');
require_once '../../lib/pluginlib.php';
require_once 'eblib/linkedin.php';
require_once 'eblib/misc.php';

$error = optional_param("error", false, PARAM_RAW);

if($error!==false) {
	if($error == "access_denied") {
		loginDenied("linkedin");
	} else {
		$errorDesc = required_param("error_description", PARAM_RAW);
		throw new moodle_exception("$errorDesc - ($error)");
	}
}

$code = required_param('code', PARAM_RAW);
$state = required_param("state", PARAM_RAW);

global $PAGE;

$PAGE->set_url("/auth/elcentra/linkedin_response.php", array("code"=>$code, "state"=>$state));

$pluginManager = plugin_manager::instance();

if(!$pluginManager->get_plugin_info("auth_elcentra", true)->is_enabled()) {
	throw new moodle_exception("Enable elcentra plugin");
}

if(isset($_SESSION['linkedin_login']['state']) && isset($_GET['state']) && ($_SESSION['linkedin_login']['state']==$state)) {
	$linkedin = new EbuildersLinkedin();
	
	$conf = get_config("auth/elcentra");
	
	$linkedinConfig = array(
			"app_id"=>$conf->linkedinclientid,
			"app_secret"=>$conf->linkedinclientsecret,
			"base_url"=>$conf->linkedin_base_url,
			"token_access_url"=>$conf->linkedin_token_access_url,
			"retrieval_url"=>$conf->linkedin_retrieval_url,
			"scope"=>$conf->linkedin_scope
	);
	
	if($linkedinConfig['app_id']=="" || $linkedinConfig['app_secret']=="") {
		throw new moodle_exception("Linkedin login is not configured. Contact admin");
	}
	
	$linkedin->setConfig($linkedinConfig);
	$linkedinReturn = $linkedin->receiveResponse($code);
	
	$prefix = "elcentra_linked_";
	$accountDetails = array(
			"$prefix".$linkedinReturn->id, //Username
			"".$linkedinReturn->{"email-address"}, //Email
			"".$linkedinReturn->{"first-name"},
			"".$linkedinReturn->{"last-name"},
			strtoupper("".$linkedinReturn->location->country->code), //Country
			"", //City
			"", //Timezone
			true, //Verified
			);
	
	require 'auth.php';
	$elcentraPlugin = new auth_plugin_elcentra();
	$elcentraPlugin->elcentraProcessResponse($accountDetails);
}